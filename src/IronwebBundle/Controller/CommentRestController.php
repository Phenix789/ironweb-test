<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use IronwebBundle\Entity\Article;
use IronwebBundle\Entity\Comment;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class CommentRestController
 *
 * @package IronwebBundle\Controller
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class CommentRestController extends AbstractRestController
{

    /**
     * @param Article $article
     *
     * @return Comment[]
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"list"})
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve a list of comments",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
     */
    public function getCommentsAction(Article $article)
    {
        return $article->getComments();
    }

    /**
     * @param Article $article
     * @param Comment $comment
     *
     * @return Comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     * @ParamConverter("comment", class="IronwebBundle:Comment")
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve a comment",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
     */
    public function getCommentAction(Article $article, Comment $comment)
    {
        if ($this->check($article, $comment)) {
            return $comment;
        }

        return $this->createViewError(array('Bad request'));
    }

    /**
     * @param Article      $article
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="content")
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Create a new comment",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function postCommentAction(Article $article, ParamFetcher $param)
    {
        return $this->handle($this->getCommentService()->createEntity($article), $param);
    }

    /**
     * @param Article      $article
     * @param Comment      $comment
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="content", nullable=true)
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Update a comment",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function putCommentAction(Article $article, Comment $comment, ParamFetcher $param)
    {
        if ($this->check($article, $comment)) {
            return $this->handle($comment, $param);
        }

        return $this->createViewError(array('Bad request'));
    }

    /**
     * @param Comment      $comment
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Comment
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function handle(Comment $comment, ParamFetcher $param)
    {
        $service = $this->getCommentService();

        $service->hydrate($comment, $param->all());
        $errors = $service->validate($comment);
        if (!count($errors)) {
            $service->save($comment);

            return $comment;
        }
        else {
            return $this->createViewFromValidationError($errors);
        }
    }

    /**
     * @param Article $article
     * @param Comment $comment
     *
     * @return bool
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function check(Article $article, Comment $comment)
    {
        return $comment->getArticle()->getId() === $article->getId();
    }

    /**
     * @return \IronwebBundle\Service\CommentService
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function getCommentService()
    {
        return $this->get('ironweb.api.comment');
    }

}
