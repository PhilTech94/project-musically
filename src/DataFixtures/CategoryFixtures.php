<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Musique de film', 'Jingle', 'Sound effect', 'Ambient', 'Mariage', 'Baptême', 'Anniversaire', 'Soirée'];

        foreach ($categories as $index => $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference('category_' . $index, $category);
        }

        $manager->flush();
    }
}
