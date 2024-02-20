<?php

namespace App\DataFixtures;

use App\Factory\AccessTokenFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;
use App\Factory\CommunityFactory;
use App\Factory\MembershipFactory;
use App\Factory\ThreadFactory;
use App\Factory\CommentFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Create 50 random users
        $numberOf = 50;
        UserFactory::createMany($numberOf);
        echo "   > $numberOf User entities successfully created.\n";

        // Create 5 subreddits created by some one the users
        $numberOf = 5;
        $communities = CommunityFactory::createMany($numberOf, function () {
            return [
                'creator' => UserFactory::random(),
            ];
        });
        $numberOf = count($communities);
        echo "   > $numberOf Subreddit entities successfully created.\n";

        /**
         * Generate 100 random memberships with a limit on consecutive attempts.
         * If max consecutive attempts are reached, duplicates will be allowed.
         */
        $existing_pairs = array();
        $max_attempts = 250;
        $allow_duplicate = false;
        $numberOfMemberships = 100; 

        MembershipFactory::createMany($numberOfMemberships, function () use (&$existing_pairs, $max_attempts, &$allow_duplicate) {
            $attempts = 0;

            while (!$allow_duplicate) {
                $user = UserFactory::random();
                $community = CommunityFactory::random();
                $id = $user->getId() . $community->getId();
                $attempts++;
                if (!in_array($id, $existing_pairs) && $community->getCreator()->getId() !== $user->getId()) {
                    array_push($existing_pairs, $id);
                    return [
                        'subreddit' => $community,
                        'member' => $user,
                    ];
                }
                if ($attempts > $max_attempts) {
                    echo "Warning: Max attempts reached. " . count($existing_pairs) . " Memberships have been created. Rest will allow duplicates.";
                    $allow_duplicate = true;
                }
            }
            // The case where duplicates are allowed 'cuz max attempts have been reached
            return [
                'subreddit' => CommunityFactory::random(),
                'member' => UserFactory::random(),
            ];
        });
        echo "   > $numberOfMemberships Membership entities successfully created.\n";

        // Generate 200 random posts based on previously generated memberships.
        $numberOf = 200; 
        ThreadFactory::createMany($numberOf, function () {
            $membership = MembershipFactory::random();
            return [
                'author' => $membership->getMember(),
                'subreddit' => $membership->getSubreddit(),
            ];
        });
        echo "   > $numberOf Post entities sucesfully created.\n";

        // Generate 200 random comments.
        //TODO: look into making comments generation fit the right communities without overloading memory
        $numberOf = 200; 
        CommentFactory::createMany($numberOf, function () {
            return [
                'author' => UserFactory::random(),
                'post' => ThreadFactory::random(),
            ];
        });
        echo "   > $numberOf Comments entities sucesfully created.\n";

        // Generate 50 access tokens.
        $numberOf = 50; 
        AccessTokenFactory::createMany($numberOf, function () {
            return [
                'ownedBy' => UserFactory::random(),
            ];
        });
        echo "   > $numberOf AccessTokens entities sucesfully created.\n";
    }
}
