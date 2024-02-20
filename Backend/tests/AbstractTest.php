<?php

namespace App\Tests;

use App\Entity\User;
use App\Factory\UserFactory;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class AbstractTest extends ApiTestCase
{
    private ?string $token = null;

    use ResetDatabase;
    use Factories;

    protected function getToken(User $user = null): ?string
    {
        if ($this->token) {
            return $this->token;
        }
        if ($user === null) {
            $user = UserFactory::createOne();
        }

        $response = static::createClient()->request('POST', '/login_json', [
            'json' => [
                'username' => $user->getLogin(),
                'password' => "password",
            ],
        ]);

        $json = json_decode($response->getContent(), true);
        $this->token = $json['token'];

        return $json['token'];
    }
}