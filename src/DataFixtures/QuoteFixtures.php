<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Quote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuoteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $quotesData = [
            ['price' => 200, 'customer' => 0],
            ['price' => 50, 'customer' => 1],
            ['price' => 110, 'customer' => 2],
        ];

        foreach ($quotesData as $index => $data) {
            $quote = new Quote();
            $quote->setPrice($data['price']);
            $quote->setCustomer($this->getReference('customer_' . $data['customer'], Customer::class));
            $manager->persist($quote);
            $this->addReference('quote_' . $index, $quote);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerFixtures::class,
        ];
    }
}
