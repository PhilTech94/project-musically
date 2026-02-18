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
            ['price' => 200, 'customer' => 0, 'description' => 'Devis pour musique de mariage'],
            ['price' => 50, 'customer' => 1, 'description' => 'Devis pour jingle publicitaire'],
            ['price' => 110, 'customer' => 2, 'description' => null],
        ];

        foreach ($quotesData as $index => $data) {
            $quote = new Quote();
            $quote->setPrice($data['price']);
            $quote->setDescription($data['description']);
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
