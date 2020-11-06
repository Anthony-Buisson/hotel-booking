<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;
    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $userRole = new Role();
        $userRole->setName('ROLE_USER');

        $adminRole = new Role();
        $adminRole->setName('ROLE_ADMIN');

        $manager->persist($userRole);
        $manager->persist($adminRole);

        $user = new User();
        $user->setEmail($faker->safeEmail)
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->addRole($userRole);

        $user1 = new User();
        $user1->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->addRole($userRole);

        $user2 = new User();
        $user2->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->addRole($adminRole);

        $manager->persist($user);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}
