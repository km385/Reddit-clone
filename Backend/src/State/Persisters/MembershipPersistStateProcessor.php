<?php

namespace App\State\Persisters;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Membership;
use App\Entity\Community;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use ApiPlatform\Validator\ValidatorInterface;

final readonly class MembershipPersistStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private EntityManagerInterface $entityManager,
        private Security $security,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @param Community $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Membership
    {
        // Take user out of token
        $user = $this->security->getUser();

        $membership = (new Membership())
            ->setMember($user)
            ->setSubreddit($data);

        // Check if unique
        if ($membership!=null){
            $this->validator->validate($membership);
        }
        
        // Increase amount of members inside community
        $data->setAmountOfMembers(isDelete: false);
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        // Save membership
        return $this->persistProcessor->process($membership, $operation, $uriVariables, $context);
    }
}