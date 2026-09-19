<?php

declare(strict_types=1);

use PHPForge\Vite\Configuration\ProductionConfiguration;
use PHPForge\Vite\Debug\{ViteCollector, VitePanel};
use PHPForge\Vite\Vite;
use Yii3\Inertia\Middleware\{CsrfTokenCookieMiddleware, InertiaMiddleware};
use Yiisoft\Csrf\CsrfTokenMiddleware;
use Yiisoft\Definitions\Reference;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Log\StreamTarget;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\RequestProvider\RequestCatcherMiddleware;
use Yiisoft\Router\Middleware\Router;
use Yiisoft\Session\SessionMiddleware;

return [
    'php-forge/vite' => [
        'configuration' => ProductionConfiguration::create(
            manifestPath: dirname(__DIR__) . '/public/build/.vite/manifest.json',
            assetBaseUrl: '/build',
        ),
        'entrypoints' => ['resources/js/app.ts'],
    ],
    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],
    'yiisoft/log' => [
        'targets' => [
            'stream' => StreamTarget::class,
        ],
    ],
    'yii3/debug' => [
        'application' => [
            'name' => 'Yii 3 + Inertia + Vue',
            'version' => '1.0',
            'charset' => 'UTF-8',
            'language' => 'en',
            'sourceLanguage' => 'en',
        ],
        'database' => [
            'excessiveCallerThreshold' => 3,
        ],
        'collectors' => [
            'vite' => ViteCollector::class,
        ],
        'panels' => [
            'vite' => VitePanel::class,
        ],
    ],
    'yiisoft/middleware-dispatcher' => [
        'middlewares' => [
            InertiaMiddleware::class,
            ErrorCatcher::class,
            SessionMiddleware::class,
            RequestBodyParser::class,
            CsrfTokenCookieMiddleware::class,
            CsrfTokenMiddleware::class,
            RequestCatcherMiddleware::class,
            Router::class,
        ],
    ],
    'yiisoft/view' => [
        'parameters' => [
            'vite' => Reference::to(Vite::class),
        ],
    ],
    'yiisoft/yii-console' => [
        'serve' => [
            'options' => [
                'port' => '8081',
            ],
        ],
    ],
    'yii3/inertia' => [
        'id' => 'app',
        'rootView' => '@root/resources/views/app.php',
        'language' => 'en',
        'charset' => 'UTF-8',
        'title' => 'Yii 3 + Inertia + Vue',
        'shared' => [
            'app' => [
                'edition' => 'Yii 3 / Inertia 3 / Vue 3.5',
                'name' => 'Yii 3 + Inertia + Vue',
                'repository' => 'yii3/app-inertia-vue',
            ],
        ],
    ],
];
