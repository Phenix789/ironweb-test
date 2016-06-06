<?php

namespace IronwebBundle\Service;

use Doctrine\ORM\EntityManager;
use IronwebBundle\Entity\Article;
use IronwebBundle\Entity\Rate;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RateService
 *
 * @package IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class RateService
{

    /** @var EntityManager */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * RateService constructor.
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
     * @param Article $article
     *
     * @return Rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function createEntity(Article $article = null)
    {
        $rate = new Rate();
        $rate->setDate(new \DateTime());

        if ($article) {
            $rate->setArticle($article);
        }

        return $rate;
    }

    /**
     * @param Rate  $rate
     * @param array $param
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function hydrate(Rate $rate, array $param)
    {
        if (isset($param['user'])) {
            $rate->setUser($param['user']);
        }
        
        if (isset($param['rate'])) {
            $rate->setRate($param['rate']);
        }

        if (isset($param['date'])) {
            $rate->setDate(new \DateTime($param['date']));
        }
    }

    /**
     * @param Rate $rate
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function validate(Rate $rate)
    {
        return $this->validator->validate($rate);
    }

    /**
     * @param Rate $rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function save(Rate $rate)
    {
        $this->entityManager->persist($rate);
        $this->entityManager->flush();
    }

}
