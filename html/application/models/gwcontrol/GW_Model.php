<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 28.08.15
 * Time: 14:59
 */

class GW_Model extends CI_Model
{
    private function extractSESSID($curl) {

        $str = $curl->response_headers->offsetGet('Set-Cookie');

        if ($str === null) {
            return null;
        }

        $match = [];
        preg_match_all('/=([a-zA-Z0-9]+);/',
            $str,
            $match
        );

        return $match[1][0];
    }

    public function getCurrentSESSID() {
        return $this->session->gwsession;
    }

    public function getCurrentUni() {
        return $this->session->gwuni;
    }

    public function __construct()
    {
        parent::__construct();

        //$this->load->model('player/PlayerModel', 'player');
        $this->load->model('uni/UniModel', 'uni');
        //$this->load->model('alliance/AllianceModel', 'alli');
    }

    public function isLoggedIn($page = '',$method = 'get',$data = []) {
        /**
         * @var $curl Curl
         */
        $curl = $this->curl;
        // get main page
        $currentSESSID = $this->getCurrentSESSID();
        $uni =$this->getCurrentUni();

        if ($currentSESSID !== null) {
            $curl->setCookie('PHPSESSID', $currentSESSID);

            $url = 'http://'.$uni.'.gigrawars.de/'.$page;
            if ($method === 'post') {
                $curl->post($url,$data);
            } else {
                $curl->get($url,$data);
            }

            $SESSID = $this->extractSESSID($curl);

            if ($SESSID === null) {
                return $curl->response;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login($uni,$user,$password) {
        /**
         * @var $curl Curl
         */


        $curl = $this->curl;
        // get main page
        $currentSESSID = $this->getCurrentSESSID();
        if ($currentSESSID !== null) {
            $curl->setCookie('PHPSESSID', $currentSESSID);
        }

        $baseUrl = 'http://'.$uni.'.gigrawars.de/';
        $curl->get($baseUrl);

        $SESSID = $this->extractSESSID($curl);

        if ($SESSID === null) {
            return $curl->response;
        } else {
            $curl->setCookie('PHPSESSID', $SESSID);
            $curl->post($baseUrl.'dashboard/', [
                'login' => $user,
                'password' => $password,
                'go' => 'Einloggen'
            ]);

            $SESSID = $this->extractSESSID($curl);
            $curl->setCookie('PHPSESSID', $SESSID);
            $curl->get($baseUrl);

            $this->session->set_userdata('gwsession', $SESSID);
            $this->session->set_userdata('gwuni', $uni);

            return $curl->response;
        }
    }

    public function parseCurrentPlanets($data) {
        $regex = '/<option\s+value="([\d]+:[\d]+:[\d]+)" ?(selected|)/';
        $planets = [];

        preg_match_all($regex,$data,$planets);

        $result = [];

        foreach ($planets[0] as $i => $p) {
            $result[$planets[1][$i]] = $planets[2][$i];
        }
        return $result;
    }

    public function parseHighscoreCount($data) {
        $regex = '/<option\s+value="([\d]+)"/';
        $match = [];

        preg_match_all($regex,$data,$match);

        return $match;
    }

    public function parseCurrentRess($data) {
        $regex = '/\s+<span class="storage js(Fe|Lut|H2O?)Storage"\s+data-ress="([\d\.]+)"\s+data-prod="([\d\.]+)"\s+data-storage="([\d\.]+)">\s+([\d\.]+)/';
        $array = [];

        preg_match_all($regex,$data,$array);

        $result = [];

        foreach($array[0] as $i => $bla) {
            $item = [
                'type' => $array[1][$i],
                'prod' => $array[3][$i],
                'storage' => $array[4][$i],
                'ress' => $array[5][$i]
            ];

            $result[] = $item;
        }

        return $result;
    }

    public function changeActivePlanet($planet) {
        /**
         * @var $curl Curl
         */
        $curl = $this->curl;

        $uni = $this->getCurrentUni();

        $url = 'http://'.$uni.'.gigrawars.de/dashboard/';

        if ($this->isLoggedIn('dashboard') !== false) {
            $curl->setHeader('X-Requested-With', 'XMLHttpRequest');
            $curl->setCookie('PHPSESSID',$this->getCurrentSESSID());
            $url = 'http://'.$uni.'.gigrawars.de/ajax/newCoords/';
            $curl->post($url,[
                'newCoord' => $planet
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function shipDeleteList() {
        /**
         * @var $curl Curl
         */
        if ($this->isLoggedIn('ship/deletelist/') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function shipBuild($ships) {
        $data = $this->isLoggedIn('ship/', 'post', [
            'ship' => $ships
        ]);

        if ($data !== false) {
            return true;
        } else {
            return false;
        }
    }


}