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
            ['name' => 'Epic Trailer', 'desc' => 'Musique épique pour bande-annonce', 'price' => 150, 'cat' => 0, 'style' => 0],
            ['name' => 'Logo Sting', 'desc' => 'Jingle court pour logo', 'price' => 50, 'cat' => 1, 'style' => 1],
            ['name' => 'Rain Loop', 'desc' => 'Boucle de pluie ambient', 'price' => 30, 'cat' => 3, 'style' => 0],
            ['name' => 'Boom Impact', 'desc' => 'Effet sonore d\'impact', 'price' => 20, 'cat' => 2, 'style' => 1],
            ['name' => 'Lo-Fi Beat', 'desc' => 'Beat lo-fi chill', 'price' => 80, 'cat' => 3, 'style' => 2],
            ['name' => 'Jazz Intro', 'desc' => 'Introduction jazz douce', 'price' => 100, 'cat' => 0, 'style' => 3],
        ];

        foreach ($soundsData as $index => $data) {
            $sound = new Sound();
            $sound->setName($data['name']);
            $sound->setDescription($data['desc']);
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
