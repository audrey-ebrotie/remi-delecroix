<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categoryNames = [
            'Mariages',
            'Paysages',
            'Famille',
            'Animaux',
            'Evènements',
            'Portraits',
        ];

        foreach ($categoryNames as $i => $name) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($faker->sentence);

            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }
}