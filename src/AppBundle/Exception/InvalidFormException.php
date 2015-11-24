<?php

namespace AppBundle\Exception;

use Symfony\Component\Form\FormInterface;

class InvalidFormException extends \Exception
{
    private $form;

    public function __construct(FormInterface $form, $message = 'Invalid form.')
    {
        parent::__construct($message);
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}
