<?php

namespace App\State\Persisters;

use ApiPlatform\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use ApiPlatform\Validator\ValidatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\UserRepository;

class UserPersistStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $processor,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private Security $security,
        private UserRepository $repository,
    ) {
    }

    /**
     * @param User $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User|null
    {
        $currentUser = $this->security->getUser();

        if ($currentUser == null) {
            throw new InvalidArgumentException('User associated with the given token was not found.', 400);
        }

        $user = $this->repository->findOneBy(['login' => $currentUser->getUserIdentifier()]);

        // Validate data
        $this->validator->validate($data);

        if ($operation->getName() == "credentials") {
            // Handle credentials
            $this->handleCredentialsPersist($data, $user);
        } else {
            // Set $isNSFW to false if it's not set in the request content
            $isNSFW = isset(json_decode($context['request']->getContent(), true)['isNSFW']);

            // Handle rest of settings
            $this->handleSettingsPersist($data, $user, $isNSFW);
        }

        return $this->processor->process($user, $operation, $uriVariables, $context);
    }



    private function handleCredentialsPersist(User $data, User $user): void
    {
        if (!$this->passwordHasher->isPasswordValid($user, $data->getPassword())) {
            throw new InvalidArgumentException('Invalid credentials.', 404);
        }

        if (!$data->getPlainPassword() && !$data->getEmail()) {
            throw new InvalidArgumentException('Either email or new password should be provided.', 400);
        }

        if ($data->getEmail()) {
            $user->setEmail($data->getEmail());
        }

        if ($data->getPlainPassword()) {
            $this->handlePasswordChange($data, $user);
        }

        $data->eraseCredentials();
    }

    private function handlePasswordChange(User $data, User $user): void
    {
        // Check length
        if (strlen($data->getPlainPassword()) < 8) {
            throw new ValidationException('Password must be at least 8 characters long.', 422);
        }

        // Check if password contains login
        $username = $user->getLogin();
        if (strpos($data->getPlainPassword(), $username) !== false) {
            throw new ValidationException('Password cannot contain your username.', 422);
        }

        // TODO:Invalidate all tokens except this one

        $hashedNewPassword = $this->passwordHasher->hashPassword($data, $data->getPlainPassword());
        $user->setPassword($hashedNewPassword);
    }

    private function handleSettingsPersist(User $data, User $user, bool $isSetNSFW): void
    {
        if (!$data->getNickname() && !$data->getDescription() && !$data->isIsNSFW()) {
            throw new InvalidArgumentException('At least one of the following should be provided: nickname, description, or NSFW status.', 400);
        }

        if ($data->getNickname()) {
            $user->setNickname($data->getNickname());
        }
        if ($data->getDescription()) {
            $user->setDescription($data->getDescription());
        }

        if ($isSetNSFW) {
            $user->setIsNSFW($data->isIsNSFW());
        }
    }
}
