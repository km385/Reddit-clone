<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Membership;
use App\Entity\Community;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


final readonly class MembershipPersistStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    /**
     * @param Community $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Membership
    {
        // Take user out of token
        $user = $this->security->getUser();

        // Check if unique combination
        $existingMembership = $this->entityManager->getRepository(Membership::class)->findOneBy([
            'member' => $user,
            'subreddit' => $data,
        ]);

        if ($existingMembership !== null) {
            throw new \Exception('You already joined this subreddit.');
        }

        $membership = (new Membership())
            ->setMember($user)
            ->setSubreddit($data);

        // Increase amount of members inside community
        $data->setTotalMembers(isDelete: false);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        // Save membership
        return $this->persistProcessor->process($membership, $operation, $uriVariables, $context);

    }

}