<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$manifestPath = "{$root}/public/build/.vite/manifest.json";

$manifestModifiedAt = is_file($manifestPath) ? filemtime($manifestPath) : false;

return [
    'yiisoft/yii-console' => [
        'serve' => [
            'options' => [
                'port' => '8081',
            ],
        ],
    ],
    'yii3/debug' => [
        'application' => [
            'charset' => 'UTF-8',
            'language' => 'en',
            'name' => 'Yii 3 + Inertia + Vue',
        ],
    ],
    'yii3/inertia' => [
        'id' => 'app',
        'rootView' => '@root/resources/views/app.php',
        'language' => 'en',
        'charset' => 'UTF-8',
        'title' => 'Yii 3 + Inertia + Vue',
        'version' => $manifestModifiedAt === false ? null : (string) $manifestModifiedAt,
        'shared' => [
            'app' => [
                'edition' => 'Yii 3 / Inertia 3 / Vue 3.5',
                'name' => 'Yii 3 + Inertia + Vue',
                'repository' => 'yii3/app-inertia-vue',
            ],
        ],
    ],
    'yiisoft/aliases' => [
        'aliases' => require __DIR__ . '/aliases.php',
    ],
];
