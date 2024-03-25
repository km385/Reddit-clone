<?php

namespace App\State\Removers;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Exception\OperationNotFoundException;
use ApiPlatform\Metadata\DeleteOperationInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use ApiPlatform\Exception\InvalidArgumentException;

class UserRemoveStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.remove_processor')]
        private ProcessorInterface $removeProcessor,
        private Security $security,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User|null
    {
        if ($operation instanceof DeleteOperationInterface) {

            // Take user out of token
            $currentUser = $this->security->getUser();
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['login' => $currentUser->getUserIdentifier()]);

            // Validate password
            if (
                !$this->passwordHasher->isPasswordValid(
                    $user,
                    json_decode($context['request']->getContent(), true)['oldPassword']
                )
            ) {
                throw new InvalidArgumentException('Invalid credentials.', 404);
            }
            //set post, comment, community to null

            // Remove user
            $this->removeProcessor->process($user, $operation, $uriVariables, $context);

            return null;

        }
        throw new OperationNotFoundException('Unknown type of operation', 500);
    }
}
