<?php

namespace App\State\Providers;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Community;
use App\Repository\CommunityRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunityStateProvider implements ProviderInterface
{
    public function __construct(
        private CommunityRepository $repository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Community
    {
        if (!isset($uriVariables['subreddit_id'])) {
            throw new NotFoundHttpException('Subreddit id was not provided.', code:400);
        }

        $DATA = $this->repository->findBy([
            'id' => $uriVariables['subreddit_id']
        ]);

        if (count($DATA) == 1) {
            return $DATA[0];

        }

        if (count($DATA) > 0) {
            throw new HttpException('Multiple Subreddits with the same id found.', 500);
        }

        throw new NotFoundHttpException(message: 'Subreddit with the given id not found.', code: 404);
    }
}