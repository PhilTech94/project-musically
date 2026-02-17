<?php

namespace App\DataFixtures;

use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StyleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $styles = ['Classique', 'Électronique', 'Hip-Hop', 'Jazz'];

        foreach ($styles as $index => $name) {
            $style = new Style();
            $style->setName($name);
            $manager->persist($style);
            $this->addReference('style_' . $index, $style);
        }

        $manager->flush();
    }
}
