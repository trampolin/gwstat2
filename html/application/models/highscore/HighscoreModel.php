<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 27.08.15
 * Time: 00:29
 */
class HighscoreModel extends CI_Model
{
    public function getHighscore() {
        $highscore = $this->db->select('h.*,
                p.current_alliance_id as alliance_id,
                p.current_name_id as name_id,
                pn.player_name,
                a.alliance_name,
                a.alliance_tag')
            ->from('gwstat2.view_highscore h')
            ->join('gwstat2.player p', 'h.player_id = p.id','left outer')
            ->join('gwstat2.player_name pn', 'p.current_name_id = pn.id','left outer')
            ->join('gwstat2.player_alliance pa', 'p.current_alliance_id = pa.id','left outer')
            ->join('gwstat2.alliance a', 'pa.alliance_id = a.id','left outer')
            ->get()
            ->result();

        return $highscore;
    }
}