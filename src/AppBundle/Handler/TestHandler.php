<?php


namespace AppBundle\Handler;


use AppBundle\Entity\Test;
use AppBundle\Form\TestForm;

class TestHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Test::class;
    }

    protected function getFormType()
    {
        return new TestForm();
    }

    public function post(array $parameters)
    {
        $test = new Test();
        $test->setCreatedBy($this->getUser());

        return $this->processForm($test, $parameters, 'POST');
    }

}