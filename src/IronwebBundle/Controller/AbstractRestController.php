<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class AbstractRestController
 *
 * @package IronwebBundle\Controller
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
abstract class AbstractRestController extends FOSRestController
{

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return \FOS\RestBundle\View\View
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function createViewError(ConstraintViolationListInterface $errors)
    {
        $msgs = array();
        foreach ($errors as $validationError) {
            $msg                                         = $validationError->getMessage();
            $params                                      = $validationError->getMessageParameters();
            $msgs[$validationError->getPropertyPath()][] = $this->get('translator')->trans($msg, $params, 'validators');
        }

        $view = View::create($msgs);
        $view->setStatusCode(400);

        return $view;
    }

}
