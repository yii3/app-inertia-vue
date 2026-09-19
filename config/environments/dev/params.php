<?php

declare(strict_types=1);

use PHPForge\Vite\Configuration\DevelopmentConfiguration;

// The `dev` environment serves assets from the Vite dev server; every other environment reads the built manifest.
return [
    'php-forge/vite' => [
        'configuration' => DevelopmentConfiguration::create(
            devServerUrl: 'http://127.0.0.1:5173',
        ),
    ],
];
