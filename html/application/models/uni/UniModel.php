<?php

class UniModel extends CI_Model
{
    public function captureUni($uni) {
        $uniData = $this->db->select()
            ->from('gwstat2.uni')
            ->where('gwstat2.uni.name', $uni)
            ->get()
            ->result();

        if (count($uniData) > 0) {
            return $uniData[0]->id;
        } else {

            $this->db->insert('gwstat2.uni', ['name' => $uni]);

            return $this->db->insert_id();
        }
    }
}