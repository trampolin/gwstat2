<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 27.08.15
 * Time: 00:29
 */
class HighscoreModel extends CI_Model
{
    /**
     * @var string
     */
    private $_highscoreCacheKey = 'current_highscore';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('player/PlayerModel', 'player');
        $this->load->model('uni/UniModel', 'uni');
        $this->load->model('alliance/AllianceModel', 'alli');


        $this->load->driver('cache', [
                'adapter' => 'memcached',
                'backup' => 'file'
            ]
        );
    }

    /**
     * @param array $filter
     * @return array mixed
     */
    public function getHighscore($filter = []) {

        $query = $this->db->select('h.*,
                pn.player_name,
                a.id as alliance_id,
                a.alliance_name,
                a.alliance_tag')
            ->from('gwstat2.view_highscore h')
            //->join('gwstat2.player p', 'h.player_id = p.id','left outer')
            ->join('gwstat2.view_playername pn', 'h.player_id = pn.player_id and h.uni_id = pn.uni_id','left outer')
            ->join('gwstat2.view_player_alliance pa', 'h.player_id = pa.player_id and h.uni_id = pa.uni_id','left outer')
            ->join('gwstat2.alliance a', 'pa.alliance_id = a.id and pa.uni_id = a.uni_id','left outer');

        if (count($filter) === 0) {
            if(!$highscore = $this->cache->get($this->_highscoreCacheKey)) {

                $highscore = $query
                    ->get()
                    ->result();

                $this->cache->save($this->_highscoreCacheKey, $highscore, 3600*24);
            }
        } else {
            $highscore = $query;

            if (isset($filter['player_id'])) {
                $highscore = $highscore->where('h.player_id', $filter['player_id']);
            }
            if (isset($filter['alliance_id'])) {
                $highscore = $highscore->where('a.id', $filter['alliance_id']);
            }

            $highscore = $highscore->get()->result();
        }

        return $highscore;
    }

    public function getHighscoreProgress($playerId) {

        $highscore = $this->db->select('h.*,
                pn.player_name,
                a.id as alliance_id,
                a.alliance_name,
                a.alliance_tag')
            ->from('gwstat2.highscore h')
            //->join('gwstat2.player p', 'h.player_id = p.id','left outer')
            ->join('gwstat2.view_playername pn', 'h.player_id = pn.player_id and h.uni_id = pn.uni_id','left outer')
            ->join('gwstat2.view_player_alliance pa', 'h.player_id = pa.player_id and h.uni_id = pa.uni_id','left outer')
            ->join('gwstat2.alliance a', 'pa.alliance_id = a.id and pa.uni_id = a.uni_id','left outer')
            ->where('h.player_id', $playerId)
            ->order_by('h.capture_first desc')
            ->get()
            ->result();

        return $highscore;
    }

    /**
     * @param string $html
     * @return array
     */
    public function parseHtml($html) {

        $highscoreRaw = [];

        $regex = '/<tr class="[a-z]*">\s*<td>([\d\.]+)<.td>\s*<td><a href="http:\/\/(.*)\.gigrawars\.de\/playerInfo\/([\d]*)\/">(.*)<\/a> <a href="http:\/\/.*\.gigrawars\.de\/alliance\/([\d]*)\/">(\[(.*)\]|)<\/a><\/td>\s*<td>([0-9\.]+)<\/td>\s*<td>([0-9\.]+)<\/td>\s*<td>([\d\.]+)<\/td>\s*<td>([0-9\.]+)<\/td>/';

        preg_match_all($regex,$html,$highscoreRaw);

        $highscore = [];

        foreach($highscoreRaw[0] as $key => $value) {
            $highscore[$highscoreRaw[1][$key]] = [
                'place' => str_replace('.','',$highscoreRaw[1][$key]),
                'uni' => $highscoreRaw[2][$key],
                'player_id' => $highscoreRaw[3][$key],
                'player_name' => $highscoreRaw[4][$key],
                'alliance_id' => $highscoreRaw[5][$key],
                'alliance_tag' => $highscoreRaw[7][$key],
                'points_planets' => str_replace('.','',$highscoreRaw[8][$key]),
                'points_research' => str_replace('.','',$highscoreRaw[9][$key]),
                'points_sum' => str_replace('.','',$highscoreRaw[10][$key]),
                'planets' => $highscoreRaw[11][$key]
            ];
        }

        return $highscore;
    }

    /**
     * @param array $rows
     * @return array
     */
    public function captureRows($rows) {

        $result = [
            'same' => 0,
            'updated' => 0,
            'new' => 0
        ];

        if (count($rows) > 0) {
            $uniIds = [];
            foreach($rows as $row) {
                // capture uni
                if (!isset($uniIds[$row['uni']])) {
                    $uniIds[$row['uni']] = $this->uni->captureUni($row['uni']);
                }

                $uniId = $uniIds[$row['uni']];

                // capture player
                $this->player->capturePlayer($uniId,$row['player_id'],$row['player_name']);

                // capture alliance
                $allianceId = $this->alli->captureAlliance($uniId,$row['alliance_id'],null,$row['alliance_tag']);

                // capture player alliance
                $this->alli->capturePlayerAlliance($uniId,$row['player_id'],$allianceId);

                // get row
                $lastHighscoreData = $this->db->select()
                    ->from('gwstat2.view_highscore')
                    ->where('uni_id', $uniId)
                    ->where('player_id', $row['player_id'])
                    ->get()
                    ->result();

                if (count($lastHighscoreData) > 0) {
                    $lastHighscoreData = $lastHighscoreData[0];

                    if (
                        $lastHighscoreData->place != $row['place']
                        || $lastHighscoreData->points_planets != $row['points_planets']
                        || $lastHighscoreData->points_research != $row['points_research']
                        || $lastHighscoreData->points_sum != $row['points_sum']
                        || $lastHighscoreData->planets != $row['planets']
                    ) {
                        // new row
                        $this->db->insert('gwstat2.highscore', [
                            'uni_id' => $uniId,
                            'player_id' => $row['player_id'],
                            'place' => $row['place'],
                            'points_planets' => $row['points_planets'],
                            'points_research' => $row['points_research'],
                            'points_sum' => $row['points_sum'],
                            'planets' => $row['planets'],
                            'capture_first' => date('Y-m-d H:n:i'),
                            'capture_last' => date('Y-m-d H:n:i')
                        ]);

                        $result['updated']++;

                    } else {
                        // just update time
                        $this->db->where('uni_id', $uniId)
                            ->where('player_id', $row['player_id'])
                            ->where('capture_last', $lastHighscoreData->capture_last)
                            ->update('gwstat2.highscore', [
                                'capture_last' => date('Y-m-d H:n:i')
                            ]);

                        $result['same']++;
                    }
                } else {
                    // just insert new row
                    $this->db->insert('gwstat2.highscore', [
                        'uni_id' => $uniId,
                        'player_id' => $row['player_id'],
                        'place' => $row['place'],
                        'points_planets' => $row['points_planets'],
                        'points_research' => $row['points_research'],
                        'points_sum' => $row['points_sum'],
                        'planets' => $row['planets']
                    ]);

                    $result['new']++;
                }
            }

        }

        return $result;
    }
}