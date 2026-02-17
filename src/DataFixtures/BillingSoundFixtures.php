<?php

namespace App\DataFixtures;

use App\Entity\Billing;
use App\Entity\BillingSound;
use App\Entity\Sound;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BillingSoundFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $billingSoundsData = [
            ['price' => 150, 'sound' => 0, 'billing' => 0],
            ['price' => 50, 'sound' => 1, 'billing' => 0],
            ['price' => 50, 'sound' => 1, 'billing' => 1],
        ];

        foreach ($billingSoundsData as $data) {
            $billingSound = new BillingSound();
            $billingSound->setPrice($data['price']);
            $billingSound->setSound($this->getReference('sound_' . $data['sound'], Sound::class));
            $billingSound->setBilling($this->getReference('billing_' . $data['billing'], Billing::class));
            $manager->persist($billingSound);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SoundFixtures::class,
            BillingFixtures::class,
        ];
    }
}
