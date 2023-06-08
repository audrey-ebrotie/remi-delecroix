<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture
{
    private $imageUrls = [
        'https://img.freepik.com/photos-gratuite/couple-mariage-france_1303-5581.jpg?1&w=2000&t=st=1685384379~exp=1685384979~hmac=418d08c948222ecfd0fa2f0bea09b1a66fada035fea83c1cbf90a8a2ddd7a240',
        'https://img.freepik.com/photos-gratuite/belle-mariee-s-assoit-bouquet-mariage-dans-voiture-retro-s-amuse_8353-7233.jpg?w=2000&t=st=1685384356~exp=1685384956~hmac=7157a7f08aa4e6ed4e0fda07abb8435de075e238e5993d4d9017b1f3283f23c8',
        'https://img.freepik.com/photos-premium/famille-jetant-petales-rose-mariee-au-marie_53876-82789.jpg?w=1800',
        'https://img.freepik.com/photos-gratuite/horse-alezan-brown-ride-criniere_1303-389.jpg?w=2000&t=st=1685384444~exp=1685385044~hmac=cc414db2de066b75ae9f68a3558111dcc57e168c0d681687d47a602aa1651420',
        'https://img.freepik.com/photos-gratuite/tir-vertical-cygne-blanc-nageant-dans-lac-hallstatt_181624-35059.jpg?w=826&t=st=1685384480~exp=1685385080~hmac=b39981b71272c612ac3e56ff278d693c6e888de2b850553b9ccd2cc672de0b40',
        'https://img.freepik.com/photos-gratuite/femme-coup-moyen-tatouages-dos_23-2149028743.jpg?w=2000&t=st=1685384520~exp=1685385120~hmac=877ae0aec4c75ec50d48aa7f3f69c943899f0a9c4d9d0a40c4790b12380f948c',
        'https://img.freepik.com/photos-gratuite/image-gros-plan-tatoueuse-tatoueuse-qui-fait-tatouage-torse-homme_613910-12221.jpg?w=2000&t=st=1685384539~exp=1685385139~hmac=c4dec5fbdf1e1784fb4e00fc45f7939ad7abfd8ed9e90be7dd87b32743afb3b3',
        'https://img.freepik.com/photos-gratuite/calanques-port-pin-cassis-france-pres-marseille_268835-884.jpg?w=2000&t=st=1685390205~exp=1685390805~hmac=5011bad7816a2d3fc359e625e692ad743fb7a06e6994bd86c8bc13ac7d2984db',
        'https://img.freepik.com/photos-gratuite/superbe-scene-crete-montagne-cote-azur_181624-35903.jpg?w=2000&t=st=1685390243~exp=1685390843~hmac=f26c3858b447ebd0f79bca262daf305193017080649538f30afa9cec04384d73',
        'https://img.freepik.com/photos-gratuite/lever-du-soleil-mesa-arch-dans-canyonlands-national-park-pres-moab-utah-usa_268835-1016.jpg?w=2000&t=st=1685390290~exp=1685390890~hmac=c546b64c3bf0f106cbd6ae50ad073657bb6ad4e10b45716dda4c9d94e3168cb1',
        'https://img.freepik.com/photos-gratuite/oiseau-perroquet-ara-rouge-couple-colore-arbre-nature_1150-34789.jpg?w=2000&t=st=1685390339~exp=1685390939~hmac=8aa4d4f56e1e3e8ccec7cd8d6d7ec927b2294da2c2fa1356bd23b451dc52929e'
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $photo = new Photo();
            $photo->setTitle($faker->sentence);
            $photo->setDescription($faker->paragraph);
            $photo->setFilename($faker->randomElement($this->imageUrls));

            $category = $this->getReference('category_' . rand(0, 4));
            $photo->setCategory($category);
            $photo->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($photo);
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
