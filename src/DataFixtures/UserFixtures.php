<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ROLES = [
        ['ROLE_USER'],
        ['ROLE_ADMIN'],
    ];

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPseudo('XDDL');
        $user->setRoles(self::ROLES[1]);

        $manager->persist($user);

        $user1 = new User();
        $user1->setPseudo('Xavier');
        $user1->setRoles(self::ROLES[0]);

        $manager->persist($user1);

        $manager->flush();
    }
}
