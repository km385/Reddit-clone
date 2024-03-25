<?php

namespace App\Tests\Api;

use App\Factory\CommunityFactory;
use App\Factory\MembershipFactory;
use App\Tests\ApiAuthenticationHelper;
use Symfony\Component\HttpFoundation\Response;

class CommunityTest extends ApiAuthenticationHelper
{
    public function testUserCanCreateCommunity(): void
    {
        $userToken = $this->login();
        $client = static::createClient();
        $response = $client->request('POST', '/api/subreddits', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
                'Authorization' => 'Bearer ' . $userToken,
            ],
            'json' => [
                'name' => "testName",
                'description' => "testDescription",
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode(),
            'Expected status code 201, but received ' . $response->getStatusCode() . '.'
        );
        $responseData = json_decode($response->getContent(), true);

        // Check owner
        $this->assertEquals(
            $this->getUserIRS(),
            $responseData['creator']['@id'],
            'Creator RSI(' . $this->getUserIRS() . ') in the response does not match the user RSI(' . $responseData['creator']['@id'] . ')'
        );

        // Check database
        $databaseCount = CommunityFactory::repository()->count();
        $this->assertEquals(
            $databaseCount,
            1,
            'Expected 1 entity inside database found: ' . $databaseCount . ' .'
        );
    }

    public function testGuestCannotCreateCommunity(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/api/subreddits', [
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ],
            'json' => [
                'name' => "testName",
                'description' => "testDescription",
            ],
        ]);

        //check status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        //check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "Full authentication is required to access this resource.",
            $responseData['detail'],
            'Expected error about authentication, but got: ' . ($responseData['detail'] ?? '""')
        );
    }

    public function testCannotCreateCommunityWithDuplicateName(): void
    {
        CommunityFactory::createOne(
            [
                'name' => "testName",
            ]
        );
        $userToken = $this->login();
        $client = static::createClient();
        $response = $client->request('POST', '/api/subreddits', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
                'Authorization' => 'Bearer ' . $userToken,
            ],
            'json' => [
                'name' => "testName",
                'description' => "testDescription",
            ],
        ]);

        //check status
        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode(),
            'Expected status code 422, but received ' . $response->getStatusCode() . '.'
        );

        //check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "name: There is already a subreddit with this name",
            $responseData['detail'],
            'Expected error message about duplicate name, but got: ' . ($responseData['detail'] ?? '""')
        );
    }

    public function testOwnerCanDeleteCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $userToken = $this->login($community->getCreator());
        $client = static::createClient();
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken,
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

    public function testUserCannotDeleteCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $userToken = $this->login();
        $client = static::createClient();
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken,
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $response->getStatusCode(),
            'Expected status code 403, but received ' . $response->getStatusCode() . '.'
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    public function testGuestCannotDeleteCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $client = static::createClient();
        $databaseCountInitial = CommunityFactory::repository()->count();
        $response = $client->request('DELETE', '/api/subreddits/' . $community->getId());

        //check status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        //check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "Full authentication is required to access this resource.",
            $responseData['detail'],
            'Expected error about authentication, but got: ' . ($responseData['detail'] ?? '""')
        );

        // Check amount
        $this->assertEquals(
            $databaseCountInitial,
            CommunityFactory::repository()->count(),
            'Community was deleted from the database.'
        );
    }

    //TODO: after refactoring comments and posts
    // public function testDeletingCommunityAlsoDeletesNestedContent(): void
    // {
    // }

    public function testOwnerCanUpdateCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $userToken = $this->login($community->getCreator());
        $client = static::createClient();
        $response = $client->request('PATCH', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                'Authorization' => 'Bearer ' . $userToken,
            ],
            'json' => [
                'name' => "Updated Name",
                'description' => "Updated Description",
            ],
        ]);
        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode(),
            'Expected status code 200, but received ' . $response->getStatusCode() . '.'
        );

        // Check updated data
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(
            "Updated Name",
            $responseData['name'],
            'Expected updated name, but got: ' . $responseData['name']
        );
        $this->assertEquals(
            "Updated Description",
            $responseData['description'],
            'Expected updated description, but got: ' . $responseData['description']
        );
    }

    public function testUserCannotUpdateCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $userToken = $this->login();
        $client = static::createClient();
        $response = $client->request('PATCH', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                'Authorization' => 'Bearer ' . $userToken,
            ],
            'json' => [
                'name' => "Updated Name",
                'description' => "Updated Description",
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $response->getStatusCode(),
            'Expected status code 403, but received ' . $response->getStatusCode() . '.'
        );
    }

    public function testCommunityCannotBeUpdatedWithWrongContent(): void
    {
        CommunityFactory::createOne(
            [
                'name' => "testName",
            ]
        );
        $community = CommunityFactory::createOne(
            [
                'name' => "testName2",
            ]
        );
        $userToken = $this->login($community->getCreator());
        $client = static::createClient();
        $response = $client->request('PATCH', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
                'Authorization' => 'Bearer ' . $userToken,
            ],
            'json' => [
                'name' => "testName",
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode(),
            'Expected status code 422, but received ' . $response->getStatusCode() . '.'
        );

        //check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "name: There is already a subreddit with this name",
            $responseData['detail'],
            'Expected error message about duplicate name, but got: ' . ($responseData['detail'] ?? '""')
        );
    }

    public function testCommunityListCanBeSortedByName(): void
    {
        CommunityFactory::createOne(['name' => 'test name 5']);
        CommunityFactory::createOne(['name' => 'test name 1']);
        CommunityFactory::createOne(['name' => 'test name 9']);

        $client = static::createClient();
        $client->request('GET', 'api/subreddits?page=1&order%5Bname%5D=desc', [
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ],
        ]);
        $responseData = $client->getResponse()->toArray()['hydra:member'];

        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            'Expected status code 200, but received ' . $client->getResponse()->getStatusCode() . '.'
        );

        // Check amount
        $this->assertCount(3, $responseData);

        // Check order
        $this->assertEquals('test name 9', $responseData[0]['name'], 'Expected first community to be "test name 9"');
        $this->assertEquals('test name 5', $responseData[1]['name'], 'Expected second community to be "test name 5"');
        $this->assertEquals('test name 1', $responseData[2]['name'], 'Expected third community to be "test name 1"');
    }

    public function testCommunityListCanBeSortedByAmountOfMembers(): void
    {
        CommunityFactory::createOne(['name' => 'test name A']);
        $communityB = CommunityFactory::createOne(['name' => 'test name B']);
        $communityC =CommunityFactory::createOne(['name' => 'test name C']);

        // Create 5 members for community B and 2 for Community C
        MembershipFactory::createMany(5,['subreddit' => $communityB]);
        MembershipFactory::createMany(2,['subreddit' => $communityC]);

        $client = static::createClient();
        $client->request('GET', 'api/subreddits?page=1&order%5BAmountOfMembers%5D=desc', [
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ],
        ]);
        $responseData = $client->getResponse()->toArray()['hydra:member'];

        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            'Expected status code 200, but received ' . $client->getResponse()->getStatusCode() . '.'
        );

        // Check amount
        $this->assertCount(3, $responseData);

        // Check order
        $this->assertEquals('test name B', $responseData[0]['name'], 'Expected first community to be "test name B with most members"');
        $this->assertEquals('test name C', $responseData[1]['name'], 'Expected second community to be "test name C"');
        $this->assertEquals('test name A', $responseData[2]['name'], 'Expected third community to be "test name A with least members"');
    }
    
    public function testCommunityListHasWorkingPagination(): void
    {
        CommunityFactory::createMany(26);
        $client = static::createClient();
        $client->request('GET', 'api/subreddits?page=1', [
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ],
        ]);
        $responseData = $client->getResponse()->toArray()['hydra:member'];

        //Check status
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            'Expected status code 200, but received ' . $client->getResponse()->getStatusCode() . '.'
        );

        // Check amount
        $this->assertCount(25, $responseData, "Expected single element but recived " . count($responseData) . ".");

        //Request second page
        $client->request('GET', 'api/subreddits?page=2', [
            'headers' => [
                'Content-Type' => 'application/ld+json'
            ],
        ]);
        $responseData = $client->getResponse()->toArray()['hydra:member'];

        // Check amount
        $this->assertCount(1, $responseData, "Expected single element but recived " . count($responseData) . ".");
    }

    public function testCommunitiesListCanBeFilteredByName(): void
    {
        CommunityFactory::createOne(['name' => 'test name ABC']);
        CommunityFactory::createOne(['name' => 'test name AB']);
        CommunityFactory::createOne(['name' => 'test name A']);

        $client = static::createClient();
        $client->request('GET', 'api/subreddits?page=1&name=AB', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
        $responseData = $client->getResponse()->toArray()['hydra:member'];

        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            'Expected status code 200, but received ' . $client->getResponse()->getStatusCode() . '.'
        );

        // Check amount
        $this->assertCount(2, $responseData);

        // Check if item was filtered
        $this->assertNotEquals('test name A', $responseData[0]['name'], 'Expected filtered community to not be "test name A"');
        $this->assertNotEquals('test name A', $responseData[1]['name'], 'Expected filtered community to not be "test name A"');
    }

    public function testOwnerCanGetCommunityDetails(): void
    {
        $community = CommunityFactory::createOne();
        $userToken = $this->login($community->getCreator());
        $client = static::createClient();
        $response = $client->request('GET', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode(),
            'Expected status code 200, but received ' . $response->getStatusCode() . '.'
        );

        // Check if status field in response
        $responseData = $response->toArray();
        $this->assertArrayHasKey('status', $responseData, 'Expected "status" field to be in the response.');
    }

    public function testGuestCannotGetCommunityDetails(): void
    {
        $community = CommunityFactory::createOne();
        $client = static::createClient();
        $response = $client->request('GET', '/api/subreddits/' . $community->getId(), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        // Check response status
        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode(),
            'Expected status code 200, but received ' . $response->getStatusCode() . '.'
        );

        // Check if status field in response
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayNotHasKey('status', $responseData, 'Unexpected "status" field in the response.');
    }

    //TODO: after writing query extensions
    // public function testGuestCannotAccessHiddenCommunities(): void
    // {
    // }
    
    //same as above
    // public function testOwnerCanAccessHiddenCommunities(): void
    // {
    // }
}
