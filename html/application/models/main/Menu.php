<?php

/**
 * Created by PhpStorm.
 * User: rmahr1
 * Date: 26.08.15
 * Time: 19:00
 */
class Menu extends CI_Model
{

    public function getMenuItems()
    {
        $menu = [
            [
                'label' => 'A',
                'href' => '',
                'icon' => 'fa-th-large',
                'items' => []
            ],
            [
                'label' => 'B',
                'href' => null,
                'icon' => 'fa-bar-chart-o',
                'items' => [
                    [
                        'label' => 'C',
                        'href' => '',
                        'icon' => 'fa-gear',
                        'items' => []
                    ],
                    [
                        'label' => 'D',
                        'href' => null,
                        'icon' => 'fa-battery-3',
                        'items' => [
                            [
                                'label' => 'E',
                                'href' => '',
                                'icon' => 'fa-th-large',
                                'items' => []
                            ],
                            [
                                'label' => 'F',
                                'href' => null,
                                'icon' => 'fa-th-large',
                                'items' => [

                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $menu;

    }
}