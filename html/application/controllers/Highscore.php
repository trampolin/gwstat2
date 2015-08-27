<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 26.08.15
 * Time: 14:25
 */
class Highscore extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('main/Menu', 'menu');
        $this->load->model('highscore/HighscoreModel', 'hs');
    }

    public function index() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $highscore = $this->hs->getHighscore();

        $this->load->view('highscore/index', [
            'highscore' => $highscore
        ]);

        $this->load->view('main/footer');
    }
}