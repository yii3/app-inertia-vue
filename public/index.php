<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Psr\Log\LogLevel;
use Yiisoft\ErrorHandler\ErrorHandler;
use Yiisoft\ErrorHandler\Renderer\HtmlRenderer;
use Yiisoft\Log\{Logger, StreamTarget};
use Yiisoft\Yii\Runner\Http\HttpApplicationRunner;

$root = dirname(__DIR__);

if (filter_var(getenv('YII_C3'), FILTER_VALIDATE_BOOL)) {
    require_once $root . '/c3.php';
}

require_once $root . '/vendor/autoload.php';

Dotenv::createImmutable($root)->safeLoad();

$environment = getenv('APP_ENV');

if ($environment === false || $environment === '') {
    $environment = $_SERVER['APP_ENV'] ?? 'prod';
}

$environment = is_string($environment) && $environment !== '' ? $environment : 'prod';
$debug = getenv('APP_DEBUG');

if ($debug === false || $debug === '') {
    $debug = $_SERVER['APP_DEBUG'] ?? false;
}

$debug = filter_var($debug, FILTER_VALIDATE_BOOL);

// PHP built-in server routing.
if (PHP_SAPI === 'cli-server') {
    // Serve static files as is.
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';

    $requestUri = is_string($requestUri) ? $requestUri : '/';
    $path = parse_url($requestUri, PHP_URL_PATH);

    if (is_string($path) && is_file(__DIR__ . $path)) {
        return false;
    }

    // Explicitly set for URLs with dot.
    $_SERVER['SCRIPT_NAME'] = '/index.php';
}

// Run HTTP application runner
$runner = new HttpApplicationRunner(
    rootPath: $root,
    debug: $debug,
    checkEvents: $debug,
    environment: $environment,
    bootstrapGroup: 'bootstrap',
    temporaryErrorHandler: new ErrorHandler(
        new Logger(
            [
                (new StreamTarget())
                    ->setLevels(
                        [
                            LogLevel::EMERGENCY,
                            LogLevel::ERROR,
                            LogLevel::WARNING,
                        ],
                    ),
            ],
        ),
        new HtmlRenderer(),
    ),
);

$runner->run();
