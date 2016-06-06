<?php

namespace IronwebBundle\Service;

use Doctrine\ORM\EntityManager;
use IronwebBundle\Entity\Article;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ArticleService
 *
 * @package IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class ArticleService
{

    /** @var EntityManager */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator     = $validator;
    }

    /**
     * @return Article
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function createEntity()
    {
        $article = new Article();
        $article->setDate(new \DateTime());

        return $article;
    }

    /**
     * @param Article $article
     * @param array   $param
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function hydrate(Article $article, array $param)
    {
        if (isset($param['title'])) {
            $article->setTitle($param['title']);
        }

        if (isset($param['content'])) {
            $article->setContent($param['content']);
        }

        if (isset($param['date'])) {
            $article->setDate(new \DateTime($param['date']));
        }
    }

    /**
     * @param Article $article
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function validate(Article $article)
    {
        return $this->validator->validate($article);
    }

    /**
     * @param Article $article
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function save(Article $article)
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

}
