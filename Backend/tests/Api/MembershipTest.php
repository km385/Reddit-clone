<?php

namespace App\Tests\Api;

use App\Factory\CommunityFactory;
use App\Factory\MembershipFactory;
use App\Factory\UserFactory;
use App\Tests\ApiAuthenticationHelper;
use Symfony\Component\HttpFoundation\Response;

class MembershipTest extends ApiAuthenticationHelper
{
    //var_dump( json_decode($response->getContent(false), true));
    public function testUserCanJoinCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $user = UserFactory::createOne();
        $token = $this->login($user);
        $response = static::createClient()->request('POST', 'api/subreddits/' . $community->getId() . '/join', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 201, but received ' . $response->getStatusCode() . '.'
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'member' => $user,
            'subreddit' => $community,
        ]);
        $this->assertCount(1, $memberships, 'Expected 1 membership, but received ' . count($memberships) . '.');
    }
    public function testUserCannotJoinNonexistentCommunity(): void
    {
        $user = UserFactory::createOne();
        $token = $this->login($user);
        $response = static::createClient()->request('POST', 'api/subreddits/' . '999' . '/join', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 404, but received ' . $response->getStatusCode() . '.'
        );

        // Check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "Subreddit with the given id not found.",
            $responseData['detail'],
            'Expected error message about nonexistant subreddit, but got: ' . ($responseData['detail'] ?? '""')
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'member' => $user,
        ]);
        $this->assertCount(0, $memberships, 'Expected 0 membership, but received ' . count($memberships) . '.');
    }

    public function testGuestCannotJoinCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $response = static::createClient()->request('POST', 'api/subreddits/' . $community->getId() . '/join', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ',
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 401, but received ' . $response->getStatusCode() . '.'
        );

        // Check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "Full authentication is required to access this resource.",
            $responseData['detail'],
            'Expected error message about authentication, but got: ' . ($responseData['detail'] ?? '""')
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'subreddit' => $community,
        ]);
        $this->assertCount(1, $memberships, 'Expected 1 membership including owner, but received ' . count($memberships) . '.');
    }

    public function testMemberCannotJoinSameCommunityTwice(): void
    {
        $community = CommunityFactory::createOne();
        $token = $this->login($community->getCreator());
        $response = static::createClient()->request('POST', 'api/subreddits/' . $community->getId() . '/join', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 422, but received ' . $response->getStatusCode() . '.'
        );

        // Check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "subreddit: You are already member of this subreddit.",
            $responseData['detail'],
            'Expected error message about duplicate membership, but got: ' . ($responseData['detail'] ?? '""')
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'subreddit' => $community,
        ]);
        $this->assertCount(1, $memberships, 'Expected 1 membership including owner, but received ' . count($memberships) . '.');
    }

    public function testMemberCanLeaveCommunity(): void
    {
        $community = CommunityFactory::createOne();
        $user = UserFactory::createOne();
        $token = $this->login($user);
        MembershipFactory::createOne([
            'member' => $user,
            'subreddit' => $community,
        ]);
        $response = static::createClient()->request('DELETE', 'api/subreddits/' . $community->getId() . '/leave', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 204, but received ' . $response->getStatusCode() . '.'
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'member' => $user,
            'subreddit' => $community,
        ]);
        $this->assertCount(0, $memberships, 'Expected 0 membership, but received ' . count($memberships) . '.');
    }

    public function testUserCannotLeaveCommunityTheyHaveNotJoined(): void
    {
        $community = CommunityFactory::createOne();
        $user = UserFactory::createOne();
        $token = $this->login($user);
        $response = static::createClient()->request('DELETE', 'api/subreddits/' . $community->getId() . '/leave', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $response->getStatusCode(),
            'Failed to join the community. Expected status code 204, but received ' . $response->getStatusCode() . '.'
        );

        // Check error
        $responseData = json_decode($response->getContent(false), true);
        $this->assertEquals(
            "You are not member of this subreddit.",
            $responseData['detail'],
            'Expected error message about not being a member, but got: ' . ($responseData['detail'] ?? '""')
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'subreddit' => $community,
        ]);
        $this->assertCount(1, $memberships, 'Expected 1 membership including owner, but received ' . count($memberships) . '.');
    }
    public function testOwnerIsAddedToMembersOnCommunityCreation(): void
    {
        $user = UserFactory::createOne();
        $token = $this->login($user);
        $response = static::createClient()->request('POST', 'api/subreddits', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => [
                'name' => 'Test Community',
                'description' => 'This is a test community.',
            ],
        ]);

        // Check request status
        $this->assertEquals(
            Response::HTTP_CREATED,
            $response->getStatusCode(),
            'Expected status code 201, but received ' . $response->getStatusCode() . '.'
        );

        // Check amount
        $memberships = MembershipFactory::findBy([
            'member' => $user,
        ]);
        $this->assertCount(1, $memberships, 'Expected owner to be added as a member, but received ' . count($memberships) . '.');
    }

    public function testNewMemberIncreasesAmountOfMembers(): void
    {
        $community = CommunityFactory::createOne();
        $token = $this->login();
        $this->assertEquals(1, $community->getAmountOfMembers(), 'Expected initial member count to be 1 (creator only).');

        static::createClient()->request('POST', 'api/subreddits/' . $community->getId() . '/join', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        // Check amount
        $this->assertEquals(2, $community->getAmountOfMembers(), 'Expected member count to increase to 2 after joining.');
    }
    public function testLeavingMemberDecreasesAmountOfMembers(): void
    {
        $community = CommunityFactory::createOne();
        $user = UserFactory::createOne();
        $token = $this->login($user);
        MembershipFactory::createOne([
            'member' => $user,
            'subreddit' => $community,
        ]);

        $this->assertEquals(2, $community->getAmountOfMembers(), 'Expected initial member count to be 2 (creator + joined user).');

        static::createClient()->request('DELETE', 'api/subreddits/' . $community->getId() . '/leave', [
            'headers' => [
                'Content-Type' => '',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        //check amount
        $this->assertEquals(1, $community->getAmountOfMembers(), 'Expected member count to decrease to 1 after leaving.');
    }
}