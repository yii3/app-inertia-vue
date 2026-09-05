<?php

declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Yiisoft\Definitions\ReferencesArray;
use Yiisoft\Log\Logger;

/** @var array{'yiisoft/log': array{targets: array<string, class-string>}} $params */
return [
    LoggerInterface::class => [
        'class' => Logger::class,
        '__construct()' => [
            'targets' => ReferencesArray::from($params['yiisoft/log']['targets']),
        ],
    ],
];
