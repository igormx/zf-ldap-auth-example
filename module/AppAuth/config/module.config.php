<?php
/**
 * Created by PhpStorm.
 * User: carlosn
 * Date: 11/09/18
 * Time: 06:55 PM
 */

return [
    'router' => [
        'routes' => [
            'auth-login' => [
                'type' => \Zend\Router\Http\Literal::class,
                'options' => [
                    'route' => "/app-auth/",
                    'defaults' => [
                        'controller' => \AppAuth\Controller\AuthController::class,
                        'action' => 'login'
                    ]
                ]
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            \AppAuth\Form\Login::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Zend\Authentication\AuthenticationService::class => \AppAuth\Factory\AppAuthServiceFactory::class
        ]
    ],
    'controllers' => [
        'factories' => [
            \AppAuth\Controller\AuthController::class => \AppAuth\Factory\AuthControllerFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];