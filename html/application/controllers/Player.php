<?php

class Player extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('main/Menu', 'menu');
        $this->load->model('highscore/HighscoreModel', 'hs');
        $this->load->model('player/PlayerModel', 'player');
    }

    public function modal($playerId) {
        $data = $this->hs->getHighscore(['player_id' => $playerId]);

        if (count($data) > 0) {
            $progress = $this->hs->getHighscoreProgress($playerId);

            $this->load->view('player/modal/player_content', [
                'data' => $data[0],
                'progress' => $progress
            ]);
        } else {
            echo 'wurst';
        }
    }
}