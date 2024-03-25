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
        // Create 100 random users
        $numberOf = 100;
        UserFactory::createMany($numberOf);
        $manager->flush();
        $manager->clear();
        echo "   > $numberOf User entities successfully created.\n";


        // Create 10 subreddits created by some one the users
        $numberOf = 10;
        CommunityFactory::createMany($numberOf, function () {
            return [
                'creator' => UserFactory::random(),
            ];
        });
        $manager->flush();
        $manager->clear();
        echo "   > $numberOf Subreddit entities successfully created.\n";


        /**
         * Generate 300 random memberships with a limit on consecutive attempts.
         * If max consecutive attempts are reached, duplicates will be allowed.
         */
        $numberOf = 300;
        $existing_pairs = array();
        $max_attempts = 600;
        $allow_duplicate = false;

        MembershipFactory::createMany($numberOf, function () use (&$existing_pairs, $max_attempts, &$allow_duplicate) {
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
        $manager->flush();
        $manager->clear();
        echo "   > $numberOf Membership entities successfully created.\n";


        // Generate 100 random posts based on previously generated memberships.
        $numberOf = 100;
        ThreadFactory::createMany($numberOf, function () {
            $membership = MembershipFactory::random();
            return [
                'author' => $membership->getMember(),
                'subreddit' => $membership->getSubreddit(),
            ];
        });
        $manager->flush();
        $manager->clear();
        echo "   > $numberOf Post entities sucesfully created.\n";


        // Generate 250 random comments.
        //todo: fix parent/sub comments
        $numberOf = 250;
        CommentFactory::createMany($numberOf, function () {
            return [
                'author' => UserFactory::random(),
                'post' => ThreadFactory::random(),
            ];
        });
        $manager->flush();
        $manager->clear();
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
