<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\AccessTokenFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use App\Factory\CommunityFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AccessTokenTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testLoginWithValidCredentials(): void
    {
        $user = UserFactory::createOne();
        $response = static::createClient()->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);
    
        // Check response status
        $this->assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode(),
            'Expected status code 201, but received ' . $response->getStatusCode() . '.'
        );
    
        // Decode JSON response
        $responseData = json_decode($response->getContent(), true);
    
        // Check token
        $token = AccessTokenFactory::findBy(['ownedBy' => $user]);
        $this->assertEquals(
            $token[0]->getToken(),
            $responseData['token'],
            'Received token (' . $responseData['token'] . ') does not match token within database (' . $token[0]->getToken() . ')'
        );
    }
    

    public function testLoginWithWrongCredentials(): void
    {
        $response = static::createClient()->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => 'invalid_username',
                'password' => 'invalid_password',
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        // Check error message
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'Invalid credentials.',
            $responseData['error'],
            'Received error message does not match expected error message.'
        );
    }

    public function testLoginWithoutCredentials(): void
    {
        $response = static::createClient()->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ],
            'json' => [
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $response->getStatusCode(),
            'Expected status code 400, but received ' . $response->getStatusCode() . '.'
        );

        // Check error message 
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'Invalid JSON.',
            $responseData['detail'],
            'Received error message does not match expected error message.'
        );
    }

    public function testLoginWithRememberMe(): void
    {
        $user = UserFactory::createOne();
        $response = static::createClient()->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
                'remember_me' => true,
            ],
        ]);
        $responseData = json_decode($response->getContent(), true);

        // Check response status
        $this->assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode(),
            'Expected status code 201, but received ' . $response->getStatusCode() . '.'
        );
        $responseData = json_decode($response->getContent(), true);

        // Check token
        $token = AccessTokenFactory::findBy(['ownedBy' => $user, 'expiresAt' => null]);
        $this->assertEquals(
            $token[0]->getToken(),
            $responseData['token'],
            'Recived token (' . $responseData['token'] . ') does not match token within database (' . $token[0]->getToken() . ')'
        );
    }

    public function testAccessProtectedEndpointWithValidToken(): void
    {
        $community = CommunityFactory::createOne();
        $user = $community->getCreator();
        $client = static::createClient();
        $response = $client->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);
        $token = json_decode($response->getContent(), true)['token'];
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode(),
            'Expected status code 204, but received ' . $response->getStatusCode() . '.'
        );

        // Check amount
        $this->assertNotEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was not deleted from the database.'
        );
    }

    public function testAccessProtectedEndpointWithoutToken(): void
    {
        $community = CommunityFactory::createOne();
        $client = static::createClient();
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        // Check error message 
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'Full authentication is required to access this resource.',
            $responseData['detail'],
            'Received error message does not match expected error message.'
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    public function testAccessProtectedEndpointWithExpiredToken(): void
    {
        $community = CommunityFactory::createOne();
        $user = $community->getCreator();
        $client = static::createClient();
        $client->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);
        $tokens = AccessTokenFactory::findBy(['ownedBy' => $user]);
        $token = $tokens[0];
        $token->setExpiresAt(new \DateTimeImmutable('-10 days'));
        $token->save();

        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getToken(),
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        // Check error message 
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'Access token has expired.',
            $responseData['detail'],
            'Received error message does not match expected error message.'
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    public function testAccessProtectedEndpointWithWrongAddress(): void
    {
        $community = CommunityFactory::createOne();
        $token = AccessTokenFactory::createOne(
            [
                'expiresAt' => null,
            ]
        );
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = static::createClient()->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getToken(),
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );
        // Check error message 
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'User address doesn\'t match.',
            $responseData['detail'],
            'Received error message does not match expected error message.'
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    public function testAccessProtectedEndpointWithSpecialCharactersInToken(): void
    {
        $community = CommunityFactory::createOne();
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = static::createClient()->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . '@#$@#$variable->(drop database)#',
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        // Check error message 
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            'Full authentication is required to access this resource.',
            $responseData['detail'],
            'Received error message does not match expected error message.'
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    public function testLogoutRemovesToken(): void
    {
        $user = UserFactory::createOne();
        $client = static::createClient();
        $response = $client->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);
        $token = json_decode($response->getContent(), true)['token'];
        $initialCount = Count(AccessTokenFactory::findBy(['ownedBy' => $user]));

        $response = $client->request('POST', 'logout_json', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode(),
            'Expected status code 204, but received ' . $response->getStatusCode() . '.'
        );

        // Check token
        $this->assertNotEquals(
            Count(AccessTokenFactory::findBy(['ownedBy' => $user])),
            $initialCount,
            'Access token was not removed on logout'
        );
    }

    public function testLogoutWithLogOutAllRemovesAllTokens(): void
    {
        $user = UserFactory::createOne();
        AccessTokenFactory::createMany(
            5,
            [
                'ownedBy' => $user,
            ]
        );
        $client = static::createClient();
        $response = $client->request('POST', 'login_json', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $user->getLogin(),
                'password' => 'password',
            ],
        ]);
        $token = json_decode($response->getContent(), true)['token'];

        $response = $client->request('POST', 'logout_json', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'logout_all' => true,
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode(),
            'Expected status code 204, but received ' . $response->getStatusCode() . '.'
        );

        // Check token
        $this->assertEquals(
            Count(AccessTokenFactory::findBy(['ownedBy' => $user])),
            0,
            'Access tokens belonging to user were not removed on logout with logout all'
        );
    }
}