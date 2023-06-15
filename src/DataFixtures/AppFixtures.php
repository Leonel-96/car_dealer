<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Car;
use App\Entity\CarCategory;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create car categories
        $categories = ['Sedan', 'SUV', 'Sports', 'Hatchback'];
        foreach ($categories as $categoryName) {
            $category = new CarCategory();
            $category->setName($categoryName);
            $manager->persist($category);

            // Generate cars for each category
            for ($i = 0; $i < 30; $i++) {
                $car = new Car();
                $car->setName($faker->word);
                $car->setNbDoors($faker->numberBetween(2, 5));
                $car->setNbSeats($faker->numberBetween(2, 7));
                $car->setCost($faker->randomFloat(2, 10000, 50000));
                $car->setCategory($category);
                $manager->persist($car);
            }
        }

        $manager->flush();
    }
}
