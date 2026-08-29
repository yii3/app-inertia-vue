<?php

declare(strict_types=1);

use App\Web\NotFound\NotFoundHandler;
use PHPForge\Vite\Vite;
use Yiisoft\Definitions\{DynamicReference, Reference};
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;
use Yiisoft\Yii\Http\Application;

/**
 * @var array{
 *     'php-forge/vite': array<string, mixed>,
 *     'yiisoft/middleware-dispatcher': array{middlewares: list<class-string>, prepend?: list<class-string>}
 * } $params
 */
$middlewareDispatcher = $params['yiisoft/middleware-dispatcher'];

$middlewares = [
    ...($middlewareDispatcher['prepend'] ?? []),
    ...$middlewareDispatcher['middlewares'],
];

return [
    Application::class => [
        '__construct()' => [
            'dispatcher' => DynamicReference::to(
                [
                    'class' => MiddlewareDispatcher::class,
                    'withMiddlewares()' => [
                        $middlewares,
                    ],
                ],
            ),
            'fallbackHandler' => Reference::to(NotFoundHandler::class),
        ],
    ],
    Vite::class => [
        '__construct()' => $params['php-forge/vite'],
    ],
];
