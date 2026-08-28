<?php

declare(strict_types=1);

use App\Web;
use Yiisoft\Router\{Group, Route};

return [
    Group::create()
        ->routes(
            Route::get('/')
                ->action(Web\Workbench\HomeAction::class)
                ->name('home'),
        ),
];
