<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    /**
     * Using faker to create (persist()) and insert (flush()) articles in database 
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {

            $faker = Factory::create();
            $article = new Article();

            $article->setTitle($faker->sentence(1))
            ->setContent($faker->sentence(15))
            ->setCreatedAt($faker->dateTime($max = 'now', $timezone = 'Europe/Paris'));

            $manager->persist($article);
        }
        $manager->flush();
    }
}
