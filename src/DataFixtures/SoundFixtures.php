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
            ['name' => 'Epic Trailer',       'price' => 49900, 'cat' => 0, 'style' => 0],
            ['name' => 'Dark Cinematic',      'price' => 39900, 'cat' => 0, 'style' => 0],
            ['name' => 'Jazz Intro',          'price' => 29900, 'cat' => 0, 'style' => 3],
            ['name' => 'Romantic Score',      'price' => 44900, 'cat' => 0, 'style' => 0],
            // Jingle (cat 1)
            ['name' => 'Logo Sting',          'price' => 14900, 'cat' => 1, 'style' => 1],
            ['name' => 'Radio Bumper',        'price' => 9900,  'cat' => 1, 'style' => 1],
            ['name' => 'TV Ident',            'price' => 19900, 'cat' => 1, 'style' => 0],
            // Sound effect (cat 2)
            ['name' => 'Boom Impact',         'price' => 4900,  'cat' => 2, 'style' => 1],
            ['name' => 'Whoosh Transition',   'price' => 2900,  'cat' => 2, 'style' => 1],
            ['name' => 'Glitch FX',           'price' => 3900,  'cat' => 2, 'style' => 1],
            // Ambient (cat 3)
            ['name' => 'Rain Loop',           'price' => 7900,  'cat' => 3, 'style' => 0],
            ['name' => 'Lo-Fi Beat',          'price' => 12900, 'cat' => 3, 'style' => 2],
            ['name' => 'Chill Groove',        'price' => 11900, 'cat' => 3, 'style' => 3],
            ['name' => 'Forest Morning',      'price' => 8900,  'cat' => 3, 'style' => 0],
            ['name' => 'Summer Vibes', 'price' => 15900, 'cat' => 3, 'style' => 1],
            // Mariage (cat 4)
            ['name' => 'Wedding March',       'price' => 59900, 'cat' => 4, 'style' => 0],
            ['name' => 'First Dance',         'price' => 49900, 'cat' => 4, 'style' => 3],
            ['name' => 'Cocktail Jazz',       'price' => 34900, 'cat' => 4, 'style' => 3],
            // Baptême (cat 5)
            ['name' => 'Baptême Doux',        'price' => 24900, 'cat' => 5, 'style' => 0],
            ['name' => 'Innocence',           'price' => 19900, 'cat' => 5, 'style' => 0],
            // Anniversaire (cat 6)
            ['name' => 'Birthday Bounce',     'price' => 14900, 'cat' => 6, 'style' => 2],
            ['name' => 'Party Anthem',        'price' => 17900, 'cat' => 6, 'style' => 1],
            // Soirée (cat 7)
            ['name' => 'Club Opener',         'price' => 22900, 'cat' => 7, 'style' => 1],
            ['name' => 'Dancefloor Builder',  'price' => 27900, 'cat' => 7, 'style' => 1],
        ];

        foreach ($soundsData as $index => $data) {
            $sound = new Sound();
            $sound->setName($data['name']);
            $sound->setPrice($data['price']);
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
