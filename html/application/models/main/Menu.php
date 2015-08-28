<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 26.08.15
 * Time: 19:00
 */
class Menu extends CI_Model
{

    /**
     * @return array
     */
    public function getMenuItems()
    {
        $menu = [
            [
                'label' => 'Home',
                'href' => '',
                'icon' => 'fa-th-large',
                'items' => []
            ],
            [
                'label' => 'Highscore',
                'href' => null,
                'icon' => 'fa-bar-chart-o',
                'items' => [
                    [
                        'label' => 'Highscore',
                        'href' => base_url().'highscore',
                        'icon' => 'fa-bar-chart-o',
                        'items' => []
                    ],
                    [
                        'label' => 'Eintragen',
                        'href' => base_url().'highscore/parse',
                        'icon' => 'fa-edit',
                        'items' => []
                    ]
                ]
            ]
        ];

        return $menu;

    }
}