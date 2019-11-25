<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    /**
     * Using faker to create (persist()) and insert (flush()) articles in database 
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($c = 0; $c < 3; $c++) {
            $category = new Category();

            $category->setName($faker->word(true));
 
            $manager->persist($category);

            for ($i = 0; $i < 20; $i++) {
                $article = new Article();

                $article->setTitle($faker->sentence(1))
                ->setContent($faker->sentence(15))
                ->setCreatedAt($faker->dateTime($max = 'now', $timezone = 'Europe/Paris'))
                ->addCategory($category);
                $manager->persist($article);
            }
            $manager->flush();
        }
    }
}
