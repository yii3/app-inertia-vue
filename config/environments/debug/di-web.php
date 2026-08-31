<?php

declare(strict_types=1);

use PHPForge\Inertia\Page;
use PHPForge\Vite\Manifest\ManifestLoader;
use Yii3\Debug\Collector\{InertiaCollector, ViteCollector};
use Yii3\Debug\ExtensionRegistry;
use Yii3\Debug\Panel\{InertiaPanel, VitePanel};
use Yii3\Inertia\ResolvedPageObserverInterface;
use Yiisoft\Definitions\Reference;

/** @var array{'php-forge/vite': array<string, mixed>} $params */
return [
    ViteCollector::class => [
        '__construct()' => [
            ...$params['php-forge/vite'],
            'manifestLoader' => Reference::optional(ManifestLoader::class),
        ],
    ],
    ExtensionRegistry::class => static fn(
        InertiaCollector $inertiaCollector,
        InertiaPanel $inertiaPanel,
        ViteCollector $viteCollector,
        VitePanel $vitePanel,
    ): ExtensionRegistry => new ExtensionRegistry(
        collectors: [$inertiaCollector, $viteCollector],
        panels: [$inertiaPanel, $vitePanel],
    ),
    ResolvedPageObserverInterface::class => static fn(
        InertiaCollector $collector,
    ): ResolvedPageObserverInterface => new readonly class ($collector) implements ResolvedPageObserverInterface {
        public function __construct(private InertiaCollector $collector) {}

        public function observe(Page $page): void
        {
            $this->collector->observe(
                $page->toArray(),
                $page->sharedProps(),
            );
        }
    },
];
