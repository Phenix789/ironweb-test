<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use IronwebBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ArticleRestController
 *
 * @package IronwebBundle\Controller
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class ArticleRestController extends FOSRestController
{

    /**
     * @return array|\IronwebBundle\Entity\Article[]
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View()
     */
    public function getArticlesAction()
    {
        return array('articles' => $this->getArticleRepository()->findAll());
    }

    /**
     * @param Article $article
     *
     * @return array
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View()
     * @ParamConverter("article", class="IronwebBundle:Article")
     */
    public function getArticleAction(Article $article)
    {
        return array('article' => $article);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|\IronwebBundle\Entity\ArticleRepository
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function getArticleRepository()
    {
        return $this->getDoctrine()->getRepository(Article::class);
    }

}
