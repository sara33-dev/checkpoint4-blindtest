<?php

namespace App\DataFixtures;

use App\Entity\Playlist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlaylistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $playlist1 = new Playlist();
        $playlist1->setNom('Chanson Française');
        $playlist1->setUrlImage('https://www.objeko.com/wp-content/uploads/2021/05/michel-sardou-aneanti-par-cette-angoisse-se-confie-sur-lenfer-de-son-quotidien-qui-le-poursuit-depuis-50-ans.jpg');
        $manager->persist($playlist1);

        $this->addReference('playlist_1', $playlist1);

        $manager->flush();
    }
}
