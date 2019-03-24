<?php

namespace Application;

use Application\Controller\Factory\ControllerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api/:controller[/:id][[/:sub][/:sub_id]]',
                    'constraints' => [
                        'id' => '[0-9]+',
                        'controller' => '[a-z\-]+',
                        'sub' => '[a-z\-]+',
                        'sub_id' => '[0-9]+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ControllerFactory::class,
            Controller\StudentController::class => ControllerFactory::class,
            Controller\ClassesController::class => ControllerFactory::class,
            Controller\TeacherController::class => ControllerFactory::class,
            Controller\JobController::class => ControllerFactory::class,
        ],
        'aliases' => [
            'student' => Controller\StudentController::class,
            'classes' => Controller\ClassesController::class,
            'teacher' => Controller\TeacherController::class,
            'job' => Controller\JobController::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
];
