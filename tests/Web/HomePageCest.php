<?php

declare(strict_types=1);

namespace App\Tests\Web;

use App\Tests\Support\WebTester;

final class HomePageCest
{
    public function homePage(WebTester $I): void
    {
        $I->wantTo('open the application home page.');
        $I->amOnPage('/');
        $I->canSeeResponseCodeIs(200);
        $I->seeInSource('<title data-inertia>Yii 3 + Inertia + Vue</title>');
        $I->seeInSource('"component":"Home"');
        $I->seeInSource('<div id="app"></div>');
    }

    public function requestedFeedPage(WebTester $I): void
    {
        $I->wantTo('receive the requested home-page feed slice.');
        $I->amOnPage('/?feed=2');
        $I->canSeeResponseCodeIs(200);
        $I->seeInSource('"page":2');
        $I->seeInSource('The boundary enters view.');
        $I->seeInSource('Only the feed is requested.');
        $I->seeInSource('New events are appended.');
    }
}
