<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use IronwebBundle\Entity\Article;
use IronwebBundle\Entity\Rate;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class RateRestController
 *
 * @package IronwebBundle\Controller
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class RateRestController extends AbstractRestController
{

    /**
     * @param Article $article
     *
     * @return Rate[]
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"list"})
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve a list of rates",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
     */
    public function getRatesAction(Article $article)
    {
        return $article->getRates();
    }

    /**
     * @param Article $article
     * @param Rate    $rate
     *
     * @return Rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     * @ParamConverter("rate", class="IronwebBundle:Rate")
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Retrieve a rate",
     *     statusCodes={
     *       200 = "Returned when successful"
     *     }
     * )
     */
    public function getRateAction(Article $article, Rate $rate)
    {
        if ($this->check($article, $rate)) {
            return $rate;
        }

        return $this->createViewError(array('Bad request'));
    }

    /**
     * @param Article      $article
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="rate")
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Create a new rate",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function postRateAction(Article $article, ParamFetcher $param)
    {
        return $this->handle($this->getRateService()->createEntity($article), $param);
    }

    /**
     * @param Article      $article
     * @param Rate         $r
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     *
     * @View(serializerGroups={"show"})
     *
     * @RequestParam(name="rate", nullable=true)
     * @RequestParam(name="date", nullable=true)
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Update a rate",
     *     statusCodes={
     *       200 = "Returned when successful",
     *       400 = "Errors"
     *     }
     * )
     */
    public function putRateAction(Article $article, Rate $r, ParamFetcher $param)
    {
        if ($this->check($article, $r)) {
            return $this->handle($r, $param);
        }

        return $this->createViewError(array('Bad request'));
    }

    /**
     * @param Rate         $rate
     * @param ParamFetcher $param
     *
     * @return \FOS\RestBundle\View\View|Rate
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function handle(Rate $rate, ParamFetcher $param)
    {
        $service = $this->getRateService();

        $service->hydrate($rate, $param->all());
        $errors = $service->validate($rate);
        if (!count($errors)) {
            $service->save($rate);

            return $rate;
        }
        else {
            return $this->createViewFromValidationError($errors);
        }
    }

    /**
     * @param Article $article
     * @param Rate    $rate
     *
     * @return bool
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function check(Article $article, Rate $rate)
    {
        return $rate->getArticle()->getId() === $article->getId();
    }

    /**
     * @return \IronwebBundle\Service\RateService
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    private function getRateService()
    {
        return $this->get('ironweb.api.rate');
    }

}
