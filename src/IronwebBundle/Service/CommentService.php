<?php

namespace IronwebBundle\Service;

use Doctrine\ORM\EntityManager;
use IronwebBundle\Entity\Article;
use IronwebBundle\Entity\Comment;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CommentService
 *
 * @package IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class CommentService
{

    /** @var EntityManager */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * CommentService constructor.
     *
     * @param EntityManager      $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator     = $validator;
    }

    /**
     * @return Comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function createEntity(Article $article = null)
    {
        $comment = new Comment();
        $comment->setDate(new \DateTime());

        if ($article) {
            $comment->setArticle($article);
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     * @param array   $param
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function hydrate(Comment $comment, array $param)
    {
        if (isset($param['content'])) {
            $comment->setContent($param['content']);
        }

        if (isset($param['date'])) {
            $comment->setDate(new \DateTime($param['date']));
        }
    }

    /**
     * @param Comment $comment
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function validate(Comment $comment)
    {
        return $this->validator->validate($comment);
    }

    /**
     * @param Comment $comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function save(Comment $comment)
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

}
