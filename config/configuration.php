<?php

declare(strict_types=1);

// NOTE: After making changes in this file, run `composer yii-config-rebuild` to update the merge plan.
return [
    'config-plugin' => [
        'params' => 'params.php',
        'params-web' => '$params',
        'params-console' => '$params',
        'di' => 'di/*.php',
        'di-web' => '$di',
        'di-console' => '$di',
        'routes' => 'routes.php',
    ],
    'config-plugin-environments' => [
        'debug' => [
            'di-web' => 'environments/debug/di-web.php',
        ],
        'dev' => [
            'di-web' => 'environments/debug/di-web.php',
        ],
        'prod' => [],
        'test' => [
            'di-web' => 'environments/debug/di-web.php',
        ],
    ],
    'config-plugin-options' => [
        'source-directory' => 'config',
    ],
];
