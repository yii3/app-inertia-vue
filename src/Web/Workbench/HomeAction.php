<?php

declare(strict_types=1);

namespace App\Web\Workbench;

use DateTimeImmutable;
use DateTimeZone;
use PHPForge\Inertia\Prop\{Prop, ScrollMetadata, ScrollProp};
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Yii3\Debug\Web\LocalAccessChecker;
use Yii3\Inertia\Inertia;

use function array_slice;
use function bin2hex;
use function count;
use function filter_var;
use function intdiv;
use function is_int;
use function min;
use function random_bytes;
use function strtoupper;

use const FILTER_VALIDATE_INT;

final readonly class HomeAction
{
    private const int FEED_PAGE_SIZE = 3;

    private const array REQUEST_FEED = [
        [
            'id' => 1,
            'layer' => 'YII ROUTER',
            'title' => 'The route selects the action.',
            'detail' => 'Yii maps the incoming request to one focused, invokable action.',
            'accent' => 'blue',
        ],
        [
            'id' => 2,
            'layer' => 'CONTAINER',
            'title' => 'Dependencies arrive ready.',
            'detail' => 'The container injects the Inertia response service into the action.',
            'accent' => 'green',
        ],
        [
            'id' => 3,
            'layer' => 'PAGE PROP',
            'title' => 'The first slice is prepared.',
            'detail' => 'The server returns three events and declares the next page cursor.',
            'accent' => 'orange',
        ],
        [
            'id' => 4,
            'layer' => 'SCROLL REGION',
            'title' => 'The boundary enters view.',
            'detail' => 'The client observes the edge of this contained scroll region.',
            'accent' => 'blue',
        ],
        [
            'id' => 5,
            'layer' => 'PARTIAL VISIT',
            'title' => 'Only the feed is requested.',
            'detail' => 'Inertia asks the server for requestFeed instead of reloading the page.',
            'accent' => 'green',
        ],
        [
            'id' => 6,
            'layer' => 'MERGE',
            'title' => 'New events are appended.',
            'detail' => 'The response marks requestFeed.data as the client-side merge path.',
            'accent' => 'orange',
        ],
        [
            'id' => 7,
            'layer' => 'VUE',
            'title' => 'The interface stays mounted.',
            'detail' => 'Vue extends the list while the surrounding page remains in place.',
            'accent' => 'blue',
        ],
        [
            'id' => 8,
            'layer' => 'HISTORY',
            'title' => 'The visible page is remembered.',
            'detail' => 'Inertia tracks the active cursor and the scroll region position.',
            'accent' => 'green',
        ],
        [
            'id' => 9,
            'layer' => 'COMPLETE',
            'title' => 'The final cursor closes the feed.',
            'detail' => 'A null next-page cursor stops loading after the last slice.',
            'accent' => 'orange',
        ],
    ];

    public function __construct(private Inertia $inertia) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->inertia->render(
            'Home',
            [
                'runtime' => self::runtimeSnapshot(...),
                'requestFeed' => self::requestFeed($request),
                'ecosystem' => Prop::defer(
                    static fn(): array => [
                        'checks' => [
                            'Constructor-injected invokable action',
                            'Explicit PSR-15 middleware pipeline',
                            'Inertia v3 partial, deferred, and scroll props',
                            'Vue page-level code splitting',
                            'Vite 8 production manifest',
                        ],
                        'packages' => 5,
                        'state' => 'Five integration checks passed',
                    ],
                    group: 'diagnostics',
                ),
            ],
            [
                'description' => 'A working Yii 3 application with Inertia 3, Vue 3.5, and Vite 8.',
                'title' => 'Yii 3 + Inertia + Vue',
            ],
        );
    }

    private static function requestFeed(ServerRequestInterface $request): ScrollProp
    {
        $total = count(self::REQUEST_FEED);
        $totalPages = intdiv($total + self::FEED_PAGE_SIZE - 1, self::FEED_PAGE_SIZE);

        $query = $request->getQueryParams();

        $requestedPage = filter_var(
            $query['feed'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]],
        );
        $page = is_int($requestedPage) ? min($requestedPage, $totalPages) : 1;

        return Prop::scroll(
            [
                'data' => array_slice(
                    self::REQUEST_FEED,
                    ($page - 1) * self::FEED_PAGE_SIZE,
                    self::FEED_PAGE_SIZE,
                ),
                'page' => $page,
                'pages' => $totalPages,
                'total' => $total,
            ],
            new ScrollMetadata(
                pageName: 'feed',
                previousPage: $page > 1 ? $page - 1 : null,
                nextPage: $page < $totalPages ? $page + 1 : null,
                currentPage: $page,
            ),
        );
    }

    /**
     * @return array{framework: string, php: string, requestId: string, servedAt: string}
     */
    private static function runtimeSnapshot(): array
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

        return [
            'framework' => 'Yii3',
            'php' => PHP_VERSION,
            'requestId' => 'REQ-' . strtoupper(bin2hex(random_bytes(6))),
            'servedAt' => $now->format('H:i:s.v') . ' UTC',
        ];
    }
}
