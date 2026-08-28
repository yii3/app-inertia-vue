<?php

declare(strict_types=1);

use App\Web\NotFound\NotFoundHandler;
use Yii3\Inertia\Middleware\{CsrfTokenCookieMiddleware, InertiaMiddleware};
use Yiisoft\Csrf\CsrfTokenMiddleware;
use Yiisoft\Definitions\{DynamicReference, Reference};
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Middleware\Dispatcher\MiddlewareDispatcher;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\RequestProvider\RequestCatcherMiddleware;
use Yiisoft\Router\Middleware\Router;
use Yiisoft\Session\SessionMiddleware;
use Yiisoft\Yii\Http\Application;

$middlewares = [
    InertiaMiddleware::class,
    ErrorCatcher::class,
    SessionMiddleware::class,
    RequestBodyParser::class,
    CsrfTokenCookieMiddleware::class,
    CsrfTokenMiddleware::class,
    RequestCatcherMiddleware::class,
    Router::class,
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
];
