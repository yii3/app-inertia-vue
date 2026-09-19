<?php

declare(strict_types=1);

use PHPForge\Vite\Debug\ViteCollector;
use PHPForge\Vite\Event\AssetsResolved;

return [
    AssetsResolved::class => [ViteCollector::class],
];
