<?php

class GW extends CI_Controller
{
    /**
     * @var GW_Model
     */
    private $gw;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('main/Menu', 'menu');
        $this->load->model('highscore/HighscoreModel', 'hs');
        $this->load->model('player/PlayerModel', 'player');
        $this->load->model('alliance/AllianceModel', 'alli');
        $this->load->model('gwcontrol/GW_Model', 'gw_m');
        $this->load->model('uni/UniModel', 'uni');

        $this->gw = $this->gw_m;
    }

    public function index() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $response = $this->gw->isLoggedIn();

        if ($response !== false) {
            $planets = $this->gw->parseCurrentPlanets($response);
            $ress = $this->gw->parseCurrentRess($response);

            $this->load->view('gwcontrol/dashboard', [
                'planets' => $planets,
                'ress' => $ress
            ]);


        } else {
            $unis = $this->uni->getUnis();

            $this->load->view('gwcontrol/login', [
                'unis' => $unis
            ]);
        }

        $this->load->view('main/footer');
    }

    public function login() {

        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $unis = $this->uni->getUnis();

        $this->load->view('gwcontrol/login', [
            'unis' => $unis
        ]);

        $this->load->view('main/footer');
    }

    public function logout() {
        $this->session->unset_userdata('gwuni');
        $this->session->unset_userdata('gwsession');

        redirect(base_url().'gw/login');
    }

    public function processLogin() {
        $this->load->view('main/header', [
            'menu' => $this->menu->getMenuItems()
        ]);

        $resp = $this->gw->login(
            $this->input->post('uni'),
            $this->input->post('user'),
            $this->input->post('password')
        );

        $gwData = [];

        redirect(base_url().'gw');

        //var_dump($this->input->post());

        $this->load->view('main/footer');
    }

    public function getHighscore() {
        $response = $this->gw->isLoggedIn('highscore/player/all/');

        if ($response !== false) {

            $array = $this->gw->parseHighscoreCount($response);

            $result = [];

            $uni = $this->gw->getCurrentUni();
            $sessid = $this->gw->getCurrentSESSID();
            $url = 'http://'.$uni.'.gigrawars.de/highscore/player/all/';

            foreach ($array[1] as $item) {

                /**
                 * @var $curl Curl
                 */
                $curl = $this->curl;
                $curl->setCookie('PHPSESSID',$sessid);
                $curl->post($url,[
                    'area' => $item
                ]);

                $parsed = $this->hs->parseHtml($curl->response);
                $result[$item] = $this->hs->captureRows($parsed);
            }

            var_dump($result);
        } else {
            echo 'false';
        }
    }

    public function changeActivePlanet($planet) {

        $this->gw->changeActivePlanet($planet);

        redirect(base_url().'gw');
    }

    public function shipDeleteList($planet) {
        $this->gw->shipDeleteList();
        redirect(base_url().'gw');
    }

    public function shipSave($planet) {
        $this->gw->changeActivePlanet($planet);
        $this->gw->shipDeleteList();
        $this->gw->shipBuild(['s7' => 10000]);
        $this->gw->shipBuild(['s6' => 10000]);
        $this->gw->shipBuild([
            's1' => 10000,
            's3' => 10000,
            's4' => 10000
        ]);
        redirect(base_url().'gw');
    }
}