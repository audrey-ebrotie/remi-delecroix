<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $categoryNames = [
            'Mariages',
            'Nature',
            'Famille',
            'Animaux',
            'Evènements'
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
