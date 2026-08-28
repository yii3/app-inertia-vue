<?php

declare(strict_types=1);

namespace App\Tests\Web;

use App\Tests\Support\WebTester;

final class NotFoundHandlerCest
{
    public function notFoundPage(WebTester $I): void
    {
        $I->wantTo('receive the application not-found page.');
        $I->amOnPage('/non-existent-page');
        $I->canSeeResponseCodeIs(404);
        $I->seeInSource('<title data-inertia>Page not found · Yii 3 + Inertia + Vue</title>');
        $I->seeInSource('"component":"NotFound"');
        $I->seeInSource('\/non-existent-page');
    }
}
