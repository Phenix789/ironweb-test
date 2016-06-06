<?php

namespace tests\IronwebBundle\Service;

use IronwebBundle\Entity\Comment;
use IronwebBundle\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CommentServiceTest
 *
 * @package tests\IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class CommentServiceTest extends KernelTestCase
{

    /** @var CommentService */
    private $service;

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->service = self::$kernel->getContainer()->get('ironweb.api.comment');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testCreateEntity()
    {
        $comment = $this->service->createEntity();

        $this->assertTrue($comment instanceof Comment);
        $this->assertEquals(null, $comment->getId(), 'Invalid comment id');
        $this->assertEquals(null, $comment->getArticle(), 'Invalid article');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testHydrate()
    {
        $comment = new Comment();
        $user    = 'root';
        $content = 'Hello World';
        $date    = '2016-01-01';
        $param   = array(
            'user'    => $user,
            'content' => $content,
            'date'    => $date
        );

        $this->service->hydrate($comment, $param);

        $this->assertEquals($user, $comment->getUser(), 'Bad hydratation user');
        $this->assertEquals($content, $comment->getContent(), 'Bad hydratation content');
        $this->assertEquals($date, $comment->getDate()->format('Y-m-d'), 'Bad hydratation date');
    }

}
