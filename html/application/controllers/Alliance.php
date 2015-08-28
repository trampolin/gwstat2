<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 28.08.15
 * Time: 14:14
 */

class Alliance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('highscore/HighscoreModel', 'hs');
    }

    public function modal($allianceId) {

        $alliance = $this->db->select()
            ->from('gwstat2.alliance')
            ->where('id', $allianceId)
            ->get()
            ->result();

        if (count($alliance) > 0) {
            $data = $this->hs->getHighscore(['alliance_id' => $allianceId]);

            $this->load->view('alliance/modal/alliance_content', [
                'alliance' => $alliance[0],
                'data' => $data
            ]);
        } else {
            echo 'wurst';
        }
    }
}