<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // optionnel : contenu en français

        $photoDirectory = __DIR__ . '/../../public/uploads/gallery_photos';
        $photoFiles = array_values(array_filter(
            scandir($photoDirectory),
            fn($file) => $file !== '.' && $file !== '..'
        ));

        if (empty($photoFiles)) {
            throw new \RuntimeException('Aucune image dans ' . $photoDirectory);
        }

        $totalFiles = count($photoFiles);

        for ($i = 0; $i < 600; $i++) {
            $photo = new Photo();
            $photo
                ->setTitle($faker->sentence)
                ->setDescription($faker->paragraph)
                ->setFilename($photoFiles[$i % $totalFiles])
                ->setCategory($this->getReference('category_' . rand(0, 5), Category::class))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(
                    $faker->dateTimeBetween('-2 years', 'now')
                ));

            $manager->persist($photo);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}