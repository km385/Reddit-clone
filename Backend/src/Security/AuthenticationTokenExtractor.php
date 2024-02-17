<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;

//TODO: remove unless needed
class AuthenticationTokenExtractor implements AccessTokenExtractorInterface
{
    private string $regex;

    public function __construct(
        private readonly string $headerParameter = 'Authorization',
        private readonly string $tokenType = 'Bearer'
    ) {
        $this->regex = sprintf(
            '/^%s([a-zA-Z0-9\-_\+~\/\.]+)$/',
            '' === $this->tokenType ? '' : preg_quote($this->tokenType).'\s+'
        );
    }

    public function extractAccessToken(Request $request): ?string
    {
        if (!$request->headers->has($this->headerParameter) || !\is_string($header = $request->headers->get($this->headerParameter))) {
            return null;
        }

        if (preg_match($this->regex, $header, $matches)) {
            $userIp = $request->getClientIp();
            //TODO: extract agent or better way to valdiate if browser was changed
            return $matches[1] . '|' . ($userIp!== null ? $userIp : '0');
        }

        return null;
    }
}
