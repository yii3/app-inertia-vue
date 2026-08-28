<?php

declare(strict_types=1);

use Yiisoft\Config\Config;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Router\{Group, Route, RouteCollection, RouteCollectionInterface, RouteCollector};

/** @var Config $config */

return [
    RouteCollectionInterface::class => [
        'class' => RouteCollection::class,
        '__construct()' => [
            'collector' => DynamicReference::to(
                static function () use ($config): RouteCollector {
                    $routes = $config->get('routes');

                    $collector = new RouteCollector();

                    foreach ($routes as $route) {
                        if (!$route instanceof Group && !$route instanceof Route) {
                            throw new UnexpectedValueException(
                                'Every configured route must be a route or route group.',
                            );
                        }

                        $collector->addRoute($route);
                    }

                    return $collector;
                },
            ),
        ],
    ],
];
