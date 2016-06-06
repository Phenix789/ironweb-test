<?php

namespace tests\IronwebBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use IronwebBundle\Entity\Article;
use IronwebBundle\Entity\Comment;
use IronwebBundle\Entity\Rate;

/**
 * Class LoadData
 *
 * @package tests\IronwebBundle\DataFixtures
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class LoadData implements FixtureInterface
{

    /**
     * @param ObjectManager $manager
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function load(ObjectManager $manager)
    {
        //$this->createFixedArticles($manager);
        $this->createRandomArticles($manager, 10, 5, 10);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function createFixedArticles(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('');
        $article1->setContent('');
        $article1->setDate(new \DateTime('-1days'));

        $manager->persist($article1);
    }

    /**
     * @param ObjectManager $manager
     * @param int           $nbArticles
     * @param int           $nbCommentsMax
     * @param int           $nbRatesMax
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function createRandomArticles(ObjectManager $manager, $nbArticles, $nbCommentsMax, $nbRatesMax)
    {
        $faker = Factory::create('en');

        $i = 0;
        while ($i++ < $nbArticles) {
            //Article
            $article = new Article();
            $article->setTitle($faker->sentence);
            $article->setContent($faker->text(rand(200, 1000)));
            $article->setDate($faker->dateTimeThisYear);

            $manager->persist($article);

            //Comment
            $j        = 0;
            $comments = rand(0, $nbCommentsMax);
            while ($j++ < $comments) {
                $comment = new Comment();
                $comment->setContent($faker->text());
                $comment->setDate($faker->dateTimeBetween($article->getDate()));
                $comment->setArticle($article);

                $manager->persist($comment);
            }

            //Rate
            $k     = 0;
            $rates = rand(0, $nbRatesMax);
            while ($k++ < $rates) {
                $rate = new Rate();
                $rate->setRate($faker->numberBetween(Rate::RATE_MIN, Rate::RATE_MAX));
                $rate->setDate($faker->dateTimeBetween($article->getDate()));
                $rate->setArticle($article);

                $manager->persist($rate);
            }
        }
    }

}
