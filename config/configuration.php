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
        'events-web' => 'events-web.php',
        'routes' => 'routes.php',
    ],
    'config-plugin-environments' => [
        'debug' => [],
        'dev' => [
            'params' => 'environments/dev/params.php',
        ],
        'prod' => [],
        'test' => [],
    ],
    'config-plugin-options' => [
        'source-directory' => 'config',
        'merge-plan-file' => '../runtime/.merge-plan.php',
    ],
];
