<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Option x2 (petit dej, lit supp)
        $option1 = new Option();
        $option1->setName('Apéro');
        $option1->setPrice(0.5);
        $manager->persist($option1);

        $option2 = new Option();
        $option2->setName('Lit supplémentaire');
        $option2->setPrice(10);
        $manager->persist($option2);

        //Room x10

        //Customer x50

        //Booking x10/30 (par Room)

        //$manager->persist($product);

        $manager->flush();
    }
}
