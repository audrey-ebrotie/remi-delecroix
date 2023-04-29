<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MediaFixtures extends Fixture
{
    private $imageUrls = [
        'https://lh3.googleusercontent.com/p/AF1QipPXRNG7u9qUHuJZz0FkVDWPcNuXaypr-_rT815_=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipNEpy3Bh6ZR2LkUqsICrnNm3u_P7KzPPXqfMWsu=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipNuecyeYPx2gMJuifM5amKLv8DSymn_VXwcDf_O=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipNAkq4FnhaCM-oGSW9L1hWZZ6DTYQL8cZkWajCB=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipNN-1gXwM1OR1TtzOJmD0jIOBGI1MzhVcZqONMz=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipMxVxD39RcFOxK8rQRROe2_bmFW357bCATXNX2X=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipM2unccGWe-bVQ21CXUS57WmD7GmNPPKKd_-bcn=s1360-w1360-h1020',
        'https://lh3.googleusercontent.com/p/AF1QipM2unccGWe-bVQ21CXUS57WmD7GmNPPKKd_-bcn=s1360-w1360-h1020',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/87518058_10218543248069989_3651564582125699072_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=730e14&_nc_ohc=QwdOCupbxwsAX-EbwAS&_nc_ht=scontent-cdg4-1.xx&oh=00_AfCEDy7RpY7SUTnRC46zFEFNKbjWk0toNMG2egDW9Klcyw&oe=6474BBFA',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/89047143_10218543254030138_5170395808335396864_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=730e14&_nc_ohc=vDAGIElf5poAX_RF_de&_nc_ht=scontent-cdg4-1.xx&oh=00_AfAkDImxFibirocU9L7MnATGaOn8MCJ34EdsJ1JX5WyXcg&oe=6474D49E',
        'https://scontent-cdg4-2.xx.fbcdn.net/v/t1.6435-9/88276811_10218543263350371_2670188314748780544_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=730e14&_nc_ohc=aY3eE5Vy_msAX_2TIQi&_nc_ht=scontent-cdg4-2.xx&oh=00_AfAxaGRG2sHjgv-RlrYwXYMsBQcsgRwnvFFEDm4_6sdvlA&oe=6474D752',
        'https://scontent-cdg4-2.xx.fbcdn.net/v/t1.6435-9/120302276_10220350534531021_8570851113858534701_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=730e14&_nc_ohc=YmwaTNKSyOsAX9Xt6FL&_nc_ht=scontent-cdg4-2.xx&oh=00_AfAzfLU5QjOCE9JSewRTpGWRV_pMglsjLQMJ-q5jQqn8Pw&oe=6474D2AE',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/193246121_10222066974840956_2895029713450751175_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=730e14&_nc_ohc=NOdl8G_sRyMAX9ROfxZ&_nc_ht=scontent-cdg4-1.xx&oh=00_AfC1-tFKvLcRRKkhLteT6KeSjcGvSUb02LKGyzPOOmvarA&oe=6474AF18',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/72740070_10217357097576968_5861356312826216448_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=730e14&_nc_ohc=ZCa0y_rLVLIAX-DRQ8a&_nc_ht=scontent-cdg4-1.xx&oh=00_AfD73oQkRnnNAiVHYyIvTzbeQogqxdswgWpbhFRDSHFKbA&oe=6474DA07',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/32532370_10213573362945967_8452560213361295360_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=730e14&_nc_ohc=x7z9JBysMY8AX_pr-Mt&_nc_ht=scontent-cdg4-1.xx&oh=00_AfAFyzKVOA_RcO3hAvr5k7oT9dV-uRvKPOsVLY98guZjew&oe=6474D22B',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/32385090_10213573361545932_8289481065341386752_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=730e14&_nc_ohc=9NON9c_QN74AX9AyYmH&_nc_ht=scontent-cdg4-1.xx&oh=00_AfDDHa4jktGAUt02qogxz2MaBdyB_-BiwTj_subEdQKHVA&oe=6474DA54',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/32582815_10213573355425779_2711756047621554176_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=730e14&_nc_ohc=BFBsU-V9QlYAX90D-Au&_nc_ht=scontent-cdg4-1.xx&oh=00_AfCNVkTNZymr_ufyjUH9jKFMPTfIzEFJrwP3wmT8eu6dCA&oe=6474D973',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t1.6435-9/74891503_10217357151258310_7772885057563262976_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=730e14&_nc_ohc=O9js3ijzSDEAX8BN7xM&_nc_ht=scontent-cdg4-1.xx&oh=00_AfB-via5k6mS0eW5snvu9hIE7p74y2C9mZxRidOSVhj7FA&oe=6474D0B8',
        'https://scontent-cdg4-2.xx.fbcdn.net/v/t39.30808-6/261094022_392988935886227_1483568670470884523_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=730e14&_nc_ohc=UuPr0IM6PMoAX9FYgkF&_nc_ht=scontent-cdg4-2.xx&oh=00_AfDpVrjsx70hgUsZm-lNkpk8rC-wk0trhdllglgIfTOdZg&oe=6452EF76',
        'https://scontent-cdg4-1.xx.fbcdn.net/v/t39.30808-6/262119245_392989022552885_2865570978954020729_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=730e14&_nc_ohc=J376vR2cXh0AX-XAX4O&_nc_ht=scontent-cdg4-1.xx&oh=00_AfC8bVpkvb-d7YkHKzALKQHqHqgJpAgWORNID9Bhp2MQYA&oe=64513998',
        'https://scontent-cdg4-2.xx.fbcdn.net/v/t39.30808-6/261766293_392961369222317_461541445117702934_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=730e14&_nc_ohc=UWTjhn9gSqYAX-o8-8F&_nc_ht=scontent-cdg4-2.xx&oh=00_AfC8tQghx77uu2c5TcalV-xwSUzP7EurdxAOhxjROfOJMA&oe=64524B19',

    ];

    private $videoUrls = [
        'public/videos/cascade-37088.mp4',
        'public/videos/coupler-77929.mp4',
        'public/videos/mariage-1330.mp4',
        'public/videos/mariage-29337.mp4'
    ];

    private $type = [
        'photo',
        'video'
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $media = new Media();
            $type = $faker->randomElement($this->type);
            $media->setType($type);
            $media->setTitle($faker->sentence);
            $media->setDescription($faker->paragraph);
            $media->setFilename($type === 'photo' ? $faker->randomElement($this->imageUrls) : $faker->randomElement($this->videoUrls));


            $category = $this->getReference('category_' . rand(0, 3));
            $media->setCategory($category);
            $media->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($media);
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
