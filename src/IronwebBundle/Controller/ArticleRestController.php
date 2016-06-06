<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use IronwebBundle\Entity\Article;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;

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
     * @View(serializerGroups={"list"})
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve a list of articles",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
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
     * @View(serializerGroups={"show"})
     * @ParamConverter("article", class="IronwebBundle:Article")
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve an article",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
     */
    public function getArticleAction(Article $article)
    {
        return array('article' => $article);
    }

    /**
     * @param ParamFetcher $param
     *
     * @return Article|\FOS\RestBundle\View\View
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="title")
     * @RequestParam(name="content")
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Create a new article",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function postArticleAction(ParamFetcher $param)
    {
        return $this->handle($this->getArticleService()->createEntity(), $param);
    }

    /**
     * @param Article      $article
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Article
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="title", nullable=true)
     * @RequestParam(name="content", nullable=true)
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Update an article",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function putArticleAction(Article $article, ParamFetcher $param)
    {
        return $this->handle($article, $param);
    }

    /**
     * @param Article      $article
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Article
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function handle(Article $article, ParamFetcher $param)
    {
        $service = $this->getArticleService();

        $service->hydrate($article, $param->all());
        $errors = $service->validate($article);
        if (!count($errors)) {
            $service->save($article);

            return $article;
        }
        else {
            return $this->createViewError($errors);
        }
    }

    /**
     * @return \IronwebBundle\Service\ArticleService
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function getArticleService()
    {
        return $this->get('ironweb.api.article');
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

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return \FOS\RestBundle\View\View
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function createViewError(ConstraintViolationListInterface $errors)
    {
        $msgs = array();
        foreach ($errors as $validationError) {
            $msg                                         = $validationError->getMessage();
            $params                                      = $validationError->getMessageParameters();
            $msgs[$validationError->getPropertyPath()][] = $this->get('translator')->trans($msg, $params, 'validators');
        }

        $view = \FOS\RestBundle\View\View::create($msgs);
        $view->setStatusCode(400);

        return $view;
    }

}
