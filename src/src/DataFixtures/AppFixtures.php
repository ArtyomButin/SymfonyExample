<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadPosts($manager);
    }

    public function loadPosts(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {
            $product = new Product();
            $product->setName($this->faker->text(20));
            $product->setDescription($this->faker->text(50));
            $product->setPrice($this->faker->numberBetween(0,100000));
            $product->setPhoto($this->faker->file("not-found-image.jpg"));

            $manager->persist($product);
        }
        $manager->flush();
    }
}
