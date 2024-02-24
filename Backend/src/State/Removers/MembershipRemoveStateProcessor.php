<?php

namespace App\State\Removers;

use ApiPlatform\Metadata\DeleteOperationInterface;
use App\Entity\Membership;
use App\Entity\Community;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class MembershipRemoveStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }
    
    /**
     * @param Community $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Membership|null
    {
        if ($operation instanceof DeleteOperationInterface) {

            // Take user out of token
            $user = $this->security->getUser();

            // Check if exist
            $existingMembership = $this->entityManager->getRepository(Membership::class)->findOneBy([
                'member' => $user,
                'subreddit' => $data,
            ]);

            if ($existingMembership === null) {
                throw new \Exception('You are not member of this subreddit.');
            }

            // Decrease amount of members inside community
            $data->setAmountOfMembers(isDelete: true);
            $this->entityManager->persist($data);
            $this->entityManager->flush();

            // Remove membership
            $this->removeProcessor->process($existingMembership, $operation, $uriVariables, $context);

            return null;

        }
        throw new \Exception('Unknown type of operation', 500);
    }
}
