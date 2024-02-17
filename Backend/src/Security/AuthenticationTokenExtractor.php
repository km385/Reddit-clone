<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

//TODO: remove unless needed
class AuthenticationTokenExtractor implements AccessTokenExtractorInterface
{
    public function extractAccessToken(Request $request): ?string
    {
        $accessToken = $request->query->get('token');
        $userIp = $request->getClientIp() ?? '0';
        $userAgent = $request->headers->get('User-Agent') ?? '0';
        $combinedString = sprintf('%s|%s|%s', $accessToken, $userIp, $userAgent);
        
        return $combinedString;
    }
}
