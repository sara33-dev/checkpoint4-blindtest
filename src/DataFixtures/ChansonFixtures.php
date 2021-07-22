<?php

namespace App\DataFixtures;

use App\Entity\Chanson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChansonFixtures extends Fixture implements DependentFixtureInterface
{
    const TITRES = [
      'L\'aventurier',
        'Femme que j\'aime',
        'Tout',
        'Macumba',
        'Les lacs du Connemara',
        'Belles belles belles',
        'J\'ai encore rêvé d\'elle',
        'Mon fils ma bataille',
        'Casser la voix',
        'Ça fait rire les oiseaux',
        'L\'aigle noir',
        'Fruit de la passion',
        'Ramenez la coupe à la maison',
        'Andalouse',
        'Anissa',
    ];

    const ARTISTES = [
        'Indochine',
        'Jean-Luc Lahaye',
        'Lara Fabian',
        'Jean-Pierre Mader',
        'Michel Sardou',
        'Claude François',
        'Il était une fois',
        'Daniel Balavoine',
        'Patrick Bruel',
        'La compagine créole',
        'Barbara',
        'Francky Vincent',
        'Vegedream',
        'Kendji Girac',
        'Wejdene',
    ];

    const URLYOUTUBES = [
        'https://www.youtube.com/watch?v=M7X6oYg6iro',
        'https://www.youtube.com/watch?v=TiqPeX5QpH8',
        'https://www.youtube.com/watch?v=Unk5Tg37aO8',
        'https://www.youtube.com/watch?v=NAYD9tiTKUQ',
        'https://www.youtube.com/watch?v=bpEmjxobvbY',
        'https://www.youtube.com/watch?v=yfhu5GJq5BQ',
        'https://www.youtube.com/watch?v=jGRaXdT2-58',
        'https://www.youtube.com/watch?v=U6HI__YOhe4',
        'https://www.youtube.com/watch?v=r-951A8fuoU',
        'https://www.youtube.com/watch?v=wfxt1SGWAI8',
        'https://www.youtube.com/watch?v=d9cEY13bUTo',
        'https://www.youtube.com/watch?v=bONeCoik1Ts',
        'https://www.youtube.com/watch?v=RHb5LKnnxLg',
        'https://www.youtube.com/watch?v=FndmvPkI1Ms',
        'https://www.youtube.com/watch?v=giW7HNq3UZM',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ARTISTES as $key => $artisteChanson ) {
            $chanson = new Chanson();
            $chanson->setPlaylistId($this->getReference('playlist_1'));
            $chanson->setArtiste($artisteChanson);
            $chanson->setTitre(self::TITRES[$key]);
            $chanson->setYoutubeId(self::URLYOUTUBES[$key]);
            $manager->persist($chanson);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaylistFixtures::class,
        ];
    }
}
