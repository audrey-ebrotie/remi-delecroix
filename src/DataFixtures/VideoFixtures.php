<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VideoFixtures extends Fixture
{
    private $videoUrls = [
        'https://www.pexels.com/video/couple-walking-down-the-aisle-8776122/'
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Get all files in the video directory
        $videoDirectory = __DIR__ . '/../../public/uploads/gallery_videos';
        $videoFiles = scandir($videoDirectory);

        // Filter out the . and .. entries
        $videoFiles = array_filter($videoFiles, function ($file) {
            return $file !== '.' && $file !== '..';
        });

        foreach ($videoFiles as $videoFile) {
            $video = new Video();
            $video->setTitle('Title for ' . $videoFile) // Set the title as you need
                ->setDescription($faker->paragraph)
                ->setFilename($videoFile);

            $category = $this->getReference('category_' . rand(0, 4));
            $video->setCategory($category);
            $video->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($video);
        }

        $manager->flush();
    }
}
