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
        $this->load->model('player/PlayerModel', 'player');
        $this->load->model('alliance/AllianceModel', 'alli');
    }

    public function index() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $highscore = $this->hs->getHighscore();

        $this->load->view('highscore/index', [
            'highscore' => $highscore
        ]);

        $this->player->playerModal();
        $this->alli->allianceModal();

        $this->load->view('main/footer');
    }

    public function parse() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $this->load->view('highscore/parse');

        $this->load->view('main/footer');

    }

    public function parseHtml() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $parsedHighscore = $this->hs->parseHtml($this->input->post('html'));

        $highscoreProcessResult = $this->hs->captureRows($parsedHighscore);

        $this->load->view('highscore/parse', [
            'html' => $this->input->post('html'),
            'parsedHighscore' => $parsedHighscore,
            'highscoreProcessResult' => $highscoreProcessResult
        ]);

        $this->load->view('main/footer');

    }
}