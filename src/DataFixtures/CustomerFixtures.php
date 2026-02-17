<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

       $customersData = [
            ['name' => 'Alice Dupont', 'phone' => '0612345678', 'mail' => 'alice@example.com'],
            ['name' => 'Bob Martin', 'phone' => '0698765432', 'mail' => 'bob@example.com'],
            ['name' => 'Clara Durand', 'phone' => null, 'mail' => 'clara@example.com'],
        ];

        foreach ($customersData as $index => $data) {
            $customer = new Customer();
            $customer->setName($data['name']);
            $customer->setPhone($data['phone']);
            $customer->setMail($data['mail']);
            $manager->persist($customer);
            $this->addReference('customer_' . $index, $customer);
        }

        $manager->flush();
    }
}
