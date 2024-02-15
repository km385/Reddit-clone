<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;
use App\Factory\CommunityFactory;
use App\Factory\MembershipFactory;
use App\Factory\ThreadFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Create 100 random users
        UserFactory::createMany(100);
        echo "   > Info: 100 User entities sucesfully created.\n";

        // Create 10 communities created by some one the users
        CommunityFactory::createMany(10, function () {
            return [
                'creator' => UserFactory::random(),
            ];
        });
        echo "   > Info: 10 Community entities sucesfully created.\n";

        /**
         * Generate 250 random memberships with a limit on consecutive attempts.
         * If max consecutive attempts are reached, duplicates will be allowed.
         */
        $existing_pairs = array();
        $max_attempts = 500;
        $allow_dublicate = false;

        MembershipFactory::createMany(250, function () use (&$existing_pairs, $max_attempts, &$allow_dublicate) {
            $attemps = 0;

            while (!$allow_dublicate) {
                $user = UserFactory::random();
                $community = CommunityFactory::random();
                $id = $user->getId() . $community->getId();
                $attemps++;
                if (!in_array($id, $existing_pairs) && $community->getCreator()->getId() !== $user->getId()) {
                    array_push($existing_pairs, $id);
                    return [
                        'community' => $community,
                        'member' => $user,
                    ];
                }
                if ($attemps > $max_attempts) {
                    echo "Warning: Max attempts reached. " . count($existing_pairs) . " Memberships have been created. Rest will allow duplicates.";
                    $allow_dublicate = true;
                }
            }

            return [
                'community' => CommunityFactory::random(),
                'member' => UserFactory::random(),
            ];
        });
        echo "   > Info: 250 Membership entities sucesfully created.\n";

        /**
         * Generate 300 random posts based on previously generated memberships.
         */
        ThreadFactory::createMany(300, function () {
            $membership = MembershipFactory::random();
            return [
                'author' => $membership->getMember(),
                'community' => $membership->getCommunity(),
            ];
        });
        echo "   > Info: 300 Post entities sucesfully created.\n";

    }
}
