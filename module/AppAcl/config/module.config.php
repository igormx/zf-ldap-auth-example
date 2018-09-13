<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 08:52 PM
 */


return [
    'router' => [
        'routes' => [
            'acl-no-permission' => [
                'type' => \Zend\Router\Http\Literal::class,
                'options' => [
                    'route' => "/app-acl/",
                    'defaults' => [
                        'controller' => \AppAcl\Controller\AclController::class,
                        'action' => 'noPermission'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            \AppAcl\Controller\AclController::class => \Zend\ServiceManager\Factory\InvokableFactory::class
        ]
     ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];