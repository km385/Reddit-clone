<?php

namespace App\State;

use ApiPlatform\Metadata\DeleteOperationInterface;
use App\Entity\Membership;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class MembershipStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        private EntityManagerInterface $entityManager,
    ) {
    }
    /**
     * @param Membership $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Membership|null
    {
        // decrease amount of members inside communities
        if ($operation instanceof DeleteOperationInterface) {
            $subreddit = $data->getSubreddit();
            $subreddit->setTotalMembers(isDelete: true);
            $this->entityManager->persist($subreddit);
            $this->removeProcessor->process($data, $operation, $uriVariables, $context);
            return null;
        }

        // increase amount of members inside communities
        $subreddit = $data->getSubreddit();
        $subreddit->setTotalMembers(isDelete: false);
        $this->entityManager->persist($subreddit);
        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
