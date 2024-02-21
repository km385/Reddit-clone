<?php

namespace App\Security\Voter;

use App\Entity\Community;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommunityVoter extends Voter
{
    public const EDIT = 'SUBRE_EDIT';
    public const VIEW = 'SUBRE_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Community;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case self::EDIT:
                if ($subject->getCreator() === $user) {
                    return true;
                }
                break;

            case self::VIEW:
                if ($subject->getCreator() === $user) {
                    return true;
                }
                break;
        }
        return false;
    }
}
