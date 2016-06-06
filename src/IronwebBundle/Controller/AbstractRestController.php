<?php

namespace IronwebBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Validator\ConstraintViolationInterface;
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
     * @param array $messages
     *
     * @return static
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function createViewError(array $messages)
    {
        $view = View::create($messages);
        $view->setStatusCode(400);

        return $view;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return \FOS\RestBundle\View\View
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function createViewFromValidationError(ConstraintViolationListInterface $errors)
    {
        $messages   = array();
        $translator = $this->get('translator');
        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()][] = $translator->trans(
                $error->getMessageTemplate(),
                $error->getParameters(),
                'validators'
            );
        }

        return $this->createViewError($messages);
    }

}
