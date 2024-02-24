<?php

namespace App\Tests;

use App\Entity\User;
use App\Factory\UserFactory;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class ApiAuthenticationHelper extends ApiTestCase
{
    private ?string $token = null;
    private ?string $userIRS = null;
    private ?string $userLogin = null;

    use ResetDatabase;
    use Factories;

    protected function login(User|Proxy $user = null): ?string
    {
        if ($user === null) {
            $user = UserFactory::createOne();
        }

        $response = static::createClient()->request('POST', '/login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);

        $json = json_decode($response->getContent(), true);
        $this->token = $json['token'];
        $this->userIRS = $json['IRS'];
        $this->userLogin = $json['login'];
        return $json['token'];
    }
    protected function getUserIRS(): ?string
    {
        return $this->userIRS;
    }

    protected function getToken(): ?string
    {
        return $this->token;
    }

    protected function getUserNickname(): ?string
    {
        return $this->userLogin;
    }
}