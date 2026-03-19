<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            [
                'firstname' => 'Jean',
                'lastname'  => 'Dupont',
                'phone'     => '0612345678',
                'email'     => 'jean.dupont@email.com',
                'password'  => 'password123',
                'roles'     => ['ROLE_USER'],
            ],
            [
                'firstname' => 'Marie',
                'lastname'  => 'Martin',
                'phone'     => '0698765432',
                'email'     => 'marie.martin@email.com',
                'password'  => 'password123',
                'roles'     => ['ROLE_USER'],
            ],
            [
                'firstname' => 'Admin',
                'lastname'  => 'Musically',
                'phone'     => '0600000000',
                'email'     => 'admin@musically.com',
                'password'  => 'admin123',
                'roles'     => ['ROLE_ADMIN'],
            ],
        ];

        foreach ($usersData as $index => $data) {
            $user = new User();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setPhone($data['phone']);
            $user->setEmail($data['email']);
            $user->setRoles($data['roles']);
            $user->setPassword($this->hasher->hashPassword($user, $data['password']));
            $manager->persist($user);
            $this->addReference('user_' . $index, $user);
        }

        $manager->flush();
    }
}
