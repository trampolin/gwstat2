<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 27.08.15
 * Time: 12:15
 */
class PlayerModel extends CI_Model
{
    private function capturePlayerName($uniId,$playerId,$playerName) {
        $playerNameData = $this->db->select()
            ->from('gwstat2.view_playername')
            ->where('uni_id', $uniId)
            ->where('player_id', $playerId)
            ->get()
            ->result();

        if (count($playerNameData) > 0) {
            // update OR insert new
            $playerNameData = $playerNameData[0];

            if ($playerNameData->player_name == $playerName) {
                // nur datum updaten
                $this->db->where('id', $playerNameData->id)
                    ->update('gwstat2.player_name', [
                        'capture_last' => date('Y-m-d H:n:i')
                    ]);

                return $playerNameData->id;
            } else {
                // neuen anlegen
                $this->db->insert('gwstat2.player_name', [
                    'uni_id' => $uniId,
                    'player_id' => $playerId,
                    'player_name' => $playerName,
                    'capture_first' => date('Y-m-d H:n:i'),
                    'capture_last' => date('Y-m-d H:n:i')
                ]);

                return $this->db->insert_id();
            }
        } else {
            // neuen anlegen
            $this->db->insert('gwstat2.player_name', [
                'uni_id' => $uniId,
                'player_id' => $playerId,
                'player_name' => $playerName
            ]);

            return $this->db->insert_id();
        }
    }

    public function capturePlayer($uniId,$playerId,$playerName) {

        // wurde der player schon mal gecaptured?
        $player = $this->db->select()
            ->from('gwstat2.player')
            ->where('id', $playerId)
            ->get()
            ->result();

        if (count($player) == 0) {
            // wurde noch nicht gecaptured

            $this->db->insert('gwstat2.player', [
                'id' => $playerId,
                'uni_id' => $uniId,
            ]);

        }

        $this->capturePlayerName($uniId,$playerId,$playerName);

        return $playerId;

    }
}