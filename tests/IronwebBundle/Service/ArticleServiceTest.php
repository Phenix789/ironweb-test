<?php

namespace tests\IronwebBundle\Service;

use Faker\Factory;
use Faker\Generator;
use IronwebBundle\Entity\Article;
use IronwebBundle\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Class ArticleServiceTest
 *
 * @package tests\IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class ArticleServiceTest extends KernelTestCase
{

    /** @var ArticleService */
    private $service;

    /** @var Generator */
    private $faker;

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->service = self::$kernel->getContainer()->get('ironweb.api.article');
        $this->faker   = Factory::create('en');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testCreateEntity()
    {
        $article = $this->service->createEntity();

        $this->assertTrue($article instanceof Article);
        $this->assertEquals(null, $article->getId(), 'Invalid article id');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testHydrate()
    {
        $article = new Article();
        $user    = 'root';
        $title   = 'Hello World';
        $content = 'Hello World';
        $date    = '2016-01-01';
        $param   = array(
            'user'    => $user,
            'title'   => $title,
            'content' => $content,
            'date'    => $date
        );

        $this->service->hydrate($article, $param);

        $this->assertEquals($user, $article->getUser(), 'Bad hydratation user');
        $this->assertEquals($title, $article->getTitle(), 'Bad hydratation title');
        $this->assertEquals($content, $article->getContent(), 'Bad hydratation content');
        $this->assertEquals($date, $article->getDate()->format('Y-m-d'), 'Bad hydratation date');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testValidateTitleLength()
    {
        $article = $this->getValidArticle();
        $title   = $this->faker->text(500);
        $article->setTitle($title);

        $errors = $this->service->validate($article);
        $fields = array();
        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $fields[] = $error->getPropertyPath();
        }

        $this->assertEquals(1, count($errors), 'Too many errors on test title length');
        $this->assertContains('title', $fields, 'Article accept title too long');
    }

    /**
     * @return Article
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function getValidArticle()
    {
        $article = new Article();
        $article->setUser($this->faker->userName);
        $article->setTitle($this->faker->text(200));
        $article->setContent($this->faker->text(1000));
        $article->setDate(new \DateTime());

        $errors = $this->service->validate($article);
        $this->assertEquals(0, count($errors), 'Unable to create a valid article');

        return $article;
    }

}
