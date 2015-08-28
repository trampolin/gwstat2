<?php
/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 27.08.15
 * Time: 21:30
 */

class Test extends CI_Controller
{
    function index() {
        /**
         * @var $curl Curl
         */
        $curl = $this->curl;

        $curl->get('http://betauni1.gigrawars.de');

        if($curl->error) {
            echo $curl->error_message;
        } else {
            echo 'load'.PHP_EOL;

            //var_dump($curl->response_headers);

            while($curl->response_headers->key() !== 'Set-Cookie') {
                $curl->response_headers->next();
            }

            echo $curl->response_headers->current();

            // -------------------------------------

            $match = [];
            preg_match_all('/=([a-zA-Z0-9]+);/',
                $curl->response_headers->current(),
                $match
            );
            $curl->setCookie('PHPSESSID', $match[1][0]);
            var_dump($match);

            $curl->post('http://betauni1.gigrawars.de/dashboard/', ['login' => 'donwinslow', 'password' => 'sitterpass01', 'go' => 'Einloggen']);

            var_dump($curl->response_headers);

            while($curl->response_headers->key() !== 'Set-Cookie') {
                $curl->response_headers->next();
            }

            echo $curl->response_headers->current();

            $match = [];
            preg_match_all('/=([a-zA-Z0-9]+);/',
                $curl->response_headers->current(),
                $match
            );
            $curl->setCookie('PHPSESSID', $match[1][0]);
            var_dump($match);

            $curl->post('http://betauni1.gigrawars.de/highscore/', [
                'area' => 401
            ]);

            var_dump($curl->response_headers);

            //echo $curl->response;

            echo 'logged in: '.$match[1][0];
        }

    }
}