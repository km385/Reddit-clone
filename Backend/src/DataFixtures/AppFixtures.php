<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;
use App\Factory\CommunityFactory;
use App\Factory\MembershipFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create 20 random users
        UserFactory::createMany(100);

        // Create 5 communities created by some one the users
        CommunityFactory::createMany(10, function () {
            return [
                'creator' => UserFactory::random(),
            ];
        });

        // Create 100 random memberships
        // Excecution time may vary, possibly needs changes
        $existing_pairs = array();
        MembershipFactory::createMany(100,  function () use (& $existing_pairs) {
            while (true) {
                $user = UserFactory::random();
                $community = CommunityFactory::random();
                $id = $user->getId() . $community->getId();
                if (!in_array($id, $existing_pairs) && $community->getCreator()->getId()!== $user->getId()) {
                    array_push($existing_pairs, $id);
                    return [
                        'community' => $community,
                        'member' => $user,
                    ];
                }
            }
        });
    }
}
