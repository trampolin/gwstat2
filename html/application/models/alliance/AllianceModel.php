<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 27.08.15
 * Time: 14:48
 */

class AllianceModel extends CI_Model
{
    public function captureAlliance($uniId,$allianceId,$allianceName,$allianceTag) {

        if ($allianceId == '' || $allianceId == null) {
            return null;
        } else {

            $allianceData = $this->db->select()
                ->from('gwstat2.alliance')
                ->where('gwstat2.alliance.uni_id', $uniId)
                ->where('gwstat2.alliance.id', $allianceId)
                ->get()
                ->result();

            if (count($allianceData) > 0) {
                return $allianceId;
            } else {

                $this->db->insert('gwstat2.alliance', [
                    'id' => $allianceId,
                    'uni_id' => $uniId,
                    'alliance_name' => $allianceName,
                    'alliance_tag' => $allianceTag
                ]);

                return $allianceId;
            }

        }
    }

    public function capturePlayerAlliance($uniId,$playerId,$allianceId) {
        $playerAllianceData = $this->db->select()
            ->from('gwstat2.view_player_alliance')
            ->where('uni_id', $uniId)
            ->where('player_id', $allianceId)
            ->get()
            ->result();

        if (count($playerAllianceData) > 0) {
            $playerAllianceData = $playerAllianceData[0];

            if ($playerAllianceData->alliance_id != $allianceId) {
                // insert new

                $this->db->insert('gwstat2.player_alliance', [
                    'uni_id' => $uniId,
                    'player_id' => $playerId,
                    'alliance_id' => $allianceId,
                    'capture_first' => date('Y-m-d H:n:i'),
                    'capture_last' => date('Y-m-d H:n:i')
                ]);

                return $this->db->insert_id();


            } else {
                // update time
                $this->db->where('id', $playerAllianceData->id)
                    ->update('gwstat2.player_alliance', ['capture_last' => date('Y-m-d H:n:i')]);

                return $playerAllianceData->id;
            }


        } else {
            $this->db->insert('gwstat2.player_alliance', [
                'uni_id' => $uniId,
                'player_id' => $playerId,
                'alliance_id' => $allianceId
            ]);

            return $this->db->insert_id();
        }
    }
}