<?php

declare(strict_types=1);

use PHPForge\Inertia\Page;
use Yii3\Debug\Collector\InertiaCollector;
use Yii3\Debug\ExtensionRegistry;
use Yii3\Debug\Panel\InertiaPanel;
use Yii3\Inertia\ResolvedPageObserverInterface;

return [
    ExtensionRegistry::class => static fn(
        InertiaCollector $collector,
        InertiaPanel $panel,
    ): ExtensionRegistry => new ExtensionRegistry(
        collectors: [$collector],
        panels: [$panel],
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
