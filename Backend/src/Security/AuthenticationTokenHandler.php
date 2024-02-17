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

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        
        $accessToken = $this->repository->findOneBy([
            'token' => $accessToken
        ]);
        if (null === $accessToken) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        if (!$accessToken->isValid()) {
            throw new CustomUserMessageAuthenticationException('Authentication token has expired.');
        }

        return new UserBadge($accessToken->getOwnedBy()->getUserIdentifier());
    }
    //TODO: remove or implement mechanism to validate both ip and agent
    // public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    // {
    //     $tokenParts = explode('|', $accessToken);

    //     if (count($tokenParts) !== 3) {
    //         throw new BadCredentialsException('Unknown authentication error.');
    //     }

    //     [$tokenValue, $userIp, $userAgent] = $tokenParts;

    //     $token = $this->repository->findOneBy([
    //         'token' => $tokenValue
    //     ]);
        
    //     if (null === $token) {
    //         throw new BadCredentialsException('Invalid credentials.');
    //     }

    //     switch ($token->isValid($userIp, $userAgent)) {
    //         case 0: // Session is valid
    //             return new UserBadge($token->getOwnedBy()->getUserIdentifier());
    //         case 1: // Session has expired
    //             throw new CustomUserMessageAuthenticationException('Authentication token has expired.');
    //         case 2: // User address doesn't match
    //             throw new CustomUserMessageAuthenticationException('User address doesn\'t match.');
    //         case 3: // User agent doesn't match
    //             throw new CustomUserMessageAuthenticationException('User agent doesn\'t match.');
    //         default:
    //             throw new CustomUserMessageAuthenticationException('Unknown authentication error.');
    //     }
    // }
}