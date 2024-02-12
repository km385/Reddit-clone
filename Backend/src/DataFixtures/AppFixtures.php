<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;
use App\Factory\CommunityFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(200);
        CommunityFactory::createMany(50, function () {
            return [
                'owner' => UserFactory::random(),
            ];
        });
        

    }
}
