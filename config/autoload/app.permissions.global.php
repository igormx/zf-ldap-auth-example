<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 13/09/18
 * Time: 06:35 PM
 */
return [
    'rbac-permission' => [
        'permissions' => [
            'home',
            'application',
            'news',
            'users'
        ],
        'roles' => [
            'users' => [
                'home',
                'news'
            ],
            'admins' => [
                'home',
                'application',
                'news',
                'users'
            ]
        ],
        'specificUsers' => [
            'elQueTienePalancas' => [
                'application',
                'news',
                'users'
            ],
            'esteban' => [
                'news'
            ]
        ]
    ]
];