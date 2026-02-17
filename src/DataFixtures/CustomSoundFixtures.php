<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\CustomSound;
use App\Entity\Sound;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomSoundFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $customSoundsData = [
            ['customer' => 0, 'sound' => 0],
            ['customer' => 1, 'sound' => 4],
            ['customer' => 2, 'sound' => 5],
        ];

        foreach ($customSoundsData as $data) {
            $customSound = new CustomSound();
            $customSound->setCustomer($this->getReference('customer_' . $data['customer'], Customer::class));
            $customSound->setSound($this->getReference('sound_' . $data['sound'], Sound::class));
            $manager->persist($customSound);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
            SoundFixtures::class,
        ];
    }
}
