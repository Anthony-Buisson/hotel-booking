<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Option;
use App\Entity\Room;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        //Option x2 (petit dej, lit supp)
        $option1 = new Option();
        $option1->setName('Apéro');
        $option1->setPrice(0.5);
        $manager->persist($option1);

        $option2 = new Option();
        $option2->setName('Lit supplémentaire');
        $option2->setPrice(10);
        $manager->persist($option2);

        $option3 = new Option();
        $option3->setName('Jaccuzzi');
        $option3->setPrice(30.6);
        $manager->persist($option3);

        $manager->flush();

        //Room x10
        $rooms = [];
        for($i = 0; $i < 10; $i++) {
            $room = new Room();
            $room->setName($faker->word())
                ->setPrice($faker->randomFloat(2,50,150))
                ->setNumber($i+1)
                ->addOption($option1);
            if($i % 3 === 0) {
                $room->addOption($option2);
            }
            $manager->persist($room);
            $rooms[] = $room;
        }
        $manager->flush();

        //Customer x50
        $customers = [];
        for($i = 0; $i < 50; $i++) {
            $customer = new Customer();
            $gender = ($i % 2 == 0) ? 'male' : 'female';
            $customer->setEmail($faker->safeEmail);
            $customer->setFirstname($faker->firstName($gender));
            $customer->setLastName($faker->lastName);
            $manager->persist($customer);
            $customers[] = $customer;
        }
        $manager->flush();

        //Booking x10/30 (par Room)
        foreach ($rooms as $room){
            $nbBooking = $faker->numberBetween(10, 30);

            for ($i = 0; $i < $nbBooking; $i++) {
                $start = $faker->dateTimeBetween('-6 month', '+6 month', 'Europe/Paris');
                $start->setTime(0,0,0,0);
                $nbNight = $faker->numberBetween(1, 10);
                $end = (clone $start)->modify("+$nbNight days");
                $createdAt = (clone $start)->modify("+$nbNight days");

                $booking = new Booking();
                $booking->setComment($faker->text);
                $booking->setCustomer($customers[$faker->numberBetween(0, count($customers)-1)]);
                $booking->setRoom($room);
                $booking->setCreatedAt($createdAt);
                $booking->setStartDate($start);
                $booking->setEndDate($end);

                $manager->persist($booking);
            }
        }
        $manager->flush();
    }
}
