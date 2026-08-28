<?php

declare(strict_types=1);

use PHPForge\Vite\Configuration\{DevelopmentConfiguration, ProductionConfiguration};
use PHPForge\Vite\Vite;

$entrypoints = ['resources/js/app.ts'];
$viteDevServer = $_SERVER['VITE_DEV_SERVER'] ?? $_ENV['VITE_DEV_SERVER'] ?? false;

$configuration = filter_var($viteDevServer, FILTER_VALIDATE_BOOL)
    ? DevelopmentConfiguration::create(
        devServerUrl: 'http://127.0.0.1:5173',
    )
    : ProductionConfiguration::create(
        manifestPath: dirname(__DIR__, 2) . '/public/build/.vite/manifest.json',
        assetBaseUrl: '/build',
    );

return [
    Vite::class => Vite::create($configuration, $entrypoints),
];
