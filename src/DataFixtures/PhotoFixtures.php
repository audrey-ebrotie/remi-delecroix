<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Get all files in the photo directory
        $photoDirectory = __DIR__ . '/../../public/uploads/gallery_photos';
        $photoFiles = scandir($photoDirectory);

        // Filter out the . and .. entries
        $photoFiles = array_filter($photoFiles, function ($file) {
            return $file !== '.' && $file !== '..';
        });

        $counter = 0; // Compteur pour limiter à 100 photos

        foreach ($photoFiles as $photoFile) {
            if ($counter >= 100) {
                break; // Sortir de la boucle si 100 photos ont été générées
            }

            $photo = new Photo();
            $photo
                ->setTitle($faker->sentence) 
                ->setDescription($faker->paragraph)
                ->setFilename($photoFile);

            $category = $this->getReference('category_' . rand(0, 4));
            $photo->setCategory($category);
            $photo->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($photo);
            
            $counter++; // Incrémenter le compteur

        }

        $manager->flush();
    }

}
