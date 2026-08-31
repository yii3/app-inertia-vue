<?php

declare(strict_types=1);

namespace App\Tests\Web;

use App\Tests\Support\WebTester;
use RuntimeException;

final class HomePageCest
{
    public function extensionDebugToolbar(WebTester $I): void
    {
        $I->wantTo('inspect the captured Inertia and Vite integrations from the debug toolbar.');
        $I->amOnPage('/');

        $dataUrl = $I->grabAttributeFrom('#yii-debug-toolbar', 'data-url');

        if (!is_string($dataUrl) || $dataUrl === '') {
            throw new RuntimeException('The debug toolbar data URL must be present.');
        }

        $I->amOnPage($dataUrl);
        $I->canSeeResponseCodeIs(200);
        $I->seeInSource('"id": "inertia"');
        $I->seeInSource('"icon": "inertia"');
        $I->seeInSource('"value": "Home"');
        $I->seeInSource('"id": "vite"');
        $I->seeInSource('"icon": "brand-javascript"');
        $I->seeInSource('"value": "Production"');
    }

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
