<?php

namespace App\DataFixtures;

use App\Entity\Billing;
use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BillingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $billingsData = [
            ['price' => 200, 'quote' => 0],
            ['price' => 50, 'quote' => 1],
        ];

        foreach ($billingsData as $index => $data) {
            $billing = new Billing();
            $billing->setPrice($data['price']);
            $billing->setQuote($this->getReference('quote_' . $data['quote'], Quote::class));
            $manager->persist($billing);
            $this->addReference('billing_' . $index, $billing);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuoteFixtures::class,
        ];
    }
}
