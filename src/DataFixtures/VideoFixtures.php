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

        for ($i = 0; $i < 50; $i++) {
            $video = new Video();
            $video->setTitle($faker->sentence);
            $video->setDescription($faker->paragraph);
            $video->setFilename($faker->randomElement($this->videoUrls));

            $category = $this->getReference('category_' . rand(0, 4));
            $video->setCategory($category);
            $video->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($video);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
