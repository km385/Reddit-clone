<?php

namespace App\Security;

use App\Repository\AuthenticationTokenRepository;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AuthenticationTokenHandler implements AccessTokenHandlerInterface
{

    public function __construct(
        private AuthenticationTokenRepository $repository
    ) {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $token): UserBadge
    {
        $tokenParts = explode('|', $token);
        if (count($tokenParts) !== 2) {
            throw new BadCredentialsException('Unknown authentication error.');
        }

        [$accessToken, $userIp] = $tokenParts;

        $accessToken = $this->repository->findOneBy([
            'token' => $accessToken
        ]);
        if (null === $accessToken) {
            throw new BadCredentialsException('Invalid credentials.');
        }
        switch ($accessToken->isValid($userIp)) {
            case '0': // Session is valid
                return new UserBadge($accessToken->getOwnedBy()->getUserIdentifier());
            case '1': // Session has expired
                throw new CustomUserMessageAuthenticationException('Authentication token has expired.');
            case '2': // User address doesn't match
                throw new CustomUserMessageAuthenticationException('User address doesn\'t match.');
            default:  // Unknown validation code
                throw new CustomUserMessageAuthenticationException('Unknown token validation code.');
        }
    }
}