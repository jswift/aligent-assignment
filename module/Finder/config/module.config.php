<?php
/**
 * Object Finder (The assignment of coding challenge for Aligent Consulting
 *
 * This file includes all the configuration items of this module which relates to the
 * essential configuration of Zend Framework and all the customized configurations.
 *
 * @copyright Copyright to Aligent Consulting in 2019
 * @since     10 July 2019
 */

namespace Finder;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/v1.0/object-finder',
                    'defaults' => [
                        'controller' => Controller\ObjectsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'objects' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/v1.0/object-finder/objects[/:action]',
                    'defaults' => [
                        'controller' => Controller\ObjectsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ObjectsController::class => InvokableFactory::class,
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
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];
