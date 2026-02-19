<?php

namespace App\DataFixtures;

use App\Entity\Billing;
use App\Enum\BillingStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BillingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $billingsData = [
            [
                'firstname'   => 'Jean',
                'lastname'    => 'Dupont',
                'phone'       => '0612345678',
                'email'       => 'jean.dupont@email.com',
                'description' => null,
                'price'       => 200,
                'status'      => BillingStatus::ACCEPTED,
            ],
            [
                'firstname'   => 'Marie',
                'lastname'    => 'Martin',
                'phone'       => '0698765432',
                'email'       => 'marie.martin@email.com',
                'description' => 'Demande de devis pour 3 sons',
                'price'       => 50,
                'status'      => BillingStatus::QUOTE,
            ],
        ];

        foreach ($billingsData as $index => $data) {
            $billing = new Billing();
            $billing->setFirstname($data['firstname']);
            $billing->setLastname($data['lastname']);
            $billing->setPhone($data['phone']);
            $billing->setEmail($data['email']);
            $billing->setDescription($data['description']);
            $billing->setPrice($data['price']);
            $billing->setStatus($data['status']);
            $manager->persist($billing);
            $this->addReference('billing_' . $index, $billing);
        }

        $manager->flush();
    }
}
