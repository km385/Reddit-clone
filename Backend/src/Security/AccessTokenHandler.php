<?php

namespace App\Security;

use App\Repository\AccessTokenRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{

    public function __construct(
        private AccessTokenRepository $repository
    ) {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $token): UserBadge
    {
        $tokenParts = explode('|', $token);
        if (count($tokenParts) !== 2) {
            throw new HttpException(500,'Unknown authentication error.');
        }

        [$token, $userIp] = $tokenParts;

        $accessTokens = $this->repository->findBy([
            "token" => $token
        ]);
        
        if (count($accessTokens) < 1) {
            throw new HttpException(404, message:'No such Access token found.');
        }

        if (count($accessTokens) !== 1) {
            throw new HttpException(500, message:'Unknown error occured during searching for token.');
        }
        $accessToken = $accessTokens[0];

        switch ($accessToken->isValid($userIp)) {
            case '0': // Session is valid
                return new UserBadge($accessToken->getOwnedBy()->getUserIdentifier());
            case '1': // Session has expired
                throw new UnauthorizedHttpException(403, message:'Access token has expired.');
            case '2': // User address doesn't match
                throw new UnauthorizedHttpException(403, message:'User address doesn\'t match.');
            default:  // Unknown validation code
            throw new UnauthorizedHttpException(400, message:'Unknown error occured during token validation.');
        }
    }
}