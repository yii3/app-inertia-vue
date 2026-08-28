<?php

declare(strict_types=1);

namespace App\Web\NotFound;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\RequestHandlerInterface;
use Yii3\Inertia\Inertia;
use Yiisoft\Http\Status;

final readonly class NotFoundHandler implements RequestHandlerInterface
{
    public function __construct(private Inertia $inertia) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->inertia
            ->render(
                'NotFound',
                ['path' => $request->getUri()->getPath()],
                [
                    'description' => 'The requested page does not exist.',
                    'title' => 'Page not found · Yii 3 + Inertia + Vue',
                ],
            )
            ->withStatus(Status::NOT_FOUND);
    }
}
