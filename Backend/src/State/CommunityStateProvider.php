<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Community;
use App\Repository\CommunityRepository;

class CommunityStateProvider implements ProviderInterface
{
    public function __construct(
        private CommunityRepository $repository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Community
    {
        if (!isset($uriVariables['subreddit_id'])) {
            throw new \Exception('Subreddit id was not provided.', 400);
        }

        $DATA = $this->repository->findBy([
            'id' => $uriVariables['subreddit_id']
        ]);

        if (count($DATA) === 1) {
            return $DATA[0];
            
        }

        if (count($DATA) > 0) {
            throw new \Exception('Multiple Subreddits with the same id found.', 500);
        }

        throw new \Exception('Subreddit with the given id not found.', 404);
    }
}