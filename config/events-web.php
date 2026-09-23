<?php

declare(strict_types=1);

use PHPForge\Vite\Debug\ViteCollector;
use PHPForge\Vite\Event\AssetsResolved;

return [
    // Routes resolved assets to the Vite collector `yii3/debug` reads; it only buffers until the debugger starts it.
    AssetsResolved::class => [ViteCollector::class],
];
