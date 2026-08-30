<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $videoDirectory = __DIR__ . '/../../public/uploads/gallery_videos';
        $videoFiles = array_values(array_filter(
            scandir($videoDirectory),
            fn($file) => $file !== '.' && $file !== '..'
        ));

        if (empty($videoFiles)) {
            throw new \RuntimeException('Aucune vidéo dans ' . $videoDirectory);
        }

        foreach ($videoFiles as $videoFile) {
            $video = new Video();
            $video
                ->setTitle($faker->sentence)
                ->setDescription($faker->paragraph)
                ->setFilename($videoFile)
                ->setCategory($this->getReference('category_' . rand(0, 5), Category::class))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable(
                    $faker->dateTimeBetween('-2 years', 'now')
                ));

            $manager->persist($video);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}