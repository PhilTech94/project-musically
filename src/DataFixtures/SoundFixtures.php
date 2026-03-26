<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Sound;
use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SoundFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $soundsData = [
            // Musique de film (cat 0)
            ['name' => 'Epic Trailer',      'price' => 49900, 'cat' => 0, 'style' => 0, 'duration' => '3:42', 'badge' => 'bestseller'],
            ['name' => 'Dark Cinematic',    'price' => 39900, 'cat' => 0, 'style' => 0, 'duration' => '4:10', 'badge' => null],
            ['name' => 'Jazz Intro',        'price' => 29900, 'cat' => 0, 'style' => 3, 'duration' => '1:55', 'badge' => 'coupdecoeur'],
            ['name' => 'Romantic Score',    'price' => 44900, 'cat' => 0, 'style' => 0, 'duration' => '3:20', 'badge' => null],
            // Jingle (cat 1)
            ['name' => 'Logo Sting',        'price' => 14900, 'cat' => 1, 'style' => 1, 'duration' => '0:08', 'badge' => null],
            ['name' => 'Radio Bumper',      'price' =>  9900, 'cat' => 1, 'style' => 1, 'duration' => '0:15', 'badge' => null],
            ['name' => 'TV Ident',          'price' => 19900, 'cat' => 1, 'style' => 0, 'duration' => '0:12', 'badge' => 'nouveaute'],
            // Sound effect (cat 2)
            ['name' => 'Boom Impact',       'price' =>  4900, 'cat' => 2, 'style' => 1, 'duration' => '0:03', 'badge' => null],
            ['name' => 'Whoosh Transition', 'price' =>  2900, 'cat' => 2, 'style' => 1, 'duration' => '0:02', 'badge' => null],
            ['name' => 'Glitch FX',         'price' =>  3900, 'cat' => 2, 'style' => 1, 'duration' => '0:05', 'badge' => null],
            // Ambient (cat 3)
            ['name' => 'Rain Loop',         'price' =>  7900, 'cat' => 3, 'style' => 0, 'duration' => '5:00', 'badge' => null],
            ['name' => 'Lo-Fi Beat',        'price' => 12900, 'cat' => 3, 'style' => 2, 'duration' => '2:30', 'badge' => 'coupdecoeur'],
            ['name' => 'Chill Groove',      'price' => 11900, 'cat' => 3, 'style' => 3, 'duration' => '2:14', 'badge' => 'bestseller'],
            ['name' => 'Forest Morning',    'price' =>  8900, 'cat' => 3, 'style' => 0, 'duration' => '4:45', 'badge' => null],
            ['name' => 'Summer Vibes',      'price' => 15900, 'cat' => 3, 'style' => 1, 'duration' => '3:05', 'badge' => 'nouveaute'],
            // Mariage (cat 4)
            ['name' => 'Wedding March',     'price' => 59900, 'cat' => 4, 'style' => 0, 'duration' => '3:15', 'badge' => 'bestseller'],
            ['name' => 'First Dance',       'price' => 49900, 'cat' => 4, 'style' => 3, 'duration' => '4:02', 'badge' => null],
            ['name' => 'Cocktail Jazz',     'price' => 34900, 'cat' => 4, 'style' => 3, 'duration' => '5:30', 'badge' => 'coupdecoeur'],
            // Baptême (cat 5)
            ['name' => 'Baptême Doux',      'price' => 24900, 'cat' => 5, 'style' => 0, 'duration' => '2:48', 'badge' => null],
            ['name' => 'Innocence',         'price' => 19900, 'cat' => 5, 'style' => 0, 'duration' => '3:10', 'badge' => null],
            // Anniversaire (cat 6)
            ['name' => 'Birthday Bounce',   'price' => 14900, 'cat' => 6, 'style' => 2, 'duration' => '1:45', 'badge' => 'bestseller'],
            ['name' => 'Party Anthem',      'price' => 17900, 'cat' => 6, 'style' => 1, 'duration' => '2:20', 'badge' => null],
            // Soirée (cat 7)
            ['name' => 'Club Opener',       'price' => 22900, 'cat' => 7, 'style' => 1, 'duration' => '4:15', 'badge' => null],
            ['name' => 'Dancefloor Builder', 'price' => 27900, 'cat' => 7, 'style' => 1, 'duration' => '6:00', 'badge' => 'nouveaute'],
        ];

        foreach ($soundsData as $index => $data) {
            $sound = new Sound();
            $sound->setName($data['name']);
            $sound->setPrice($data['price']);
            $sound->setDuration($data['duration']);
            $sound->setBadge($data['badge']);
            $sound->setCategory($this->getReference('category_' . $data['cat'], Category::class));
            $sound->setStyle($this->getReference('style_' . $data['style'], Style::class));
            $manager->persist($sound);
            $this->addReference('sound_' . $index, $sound);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            StyleFixtures::class,
        ];
    }
}
