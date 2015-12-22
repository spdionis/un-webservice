<?php


namespace AppBundle\Handler;


use AppBundle\Entity\BaseQuestion;
use AppBundle\Form\BaseQuestionForm;

class BaseQuestionHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return BaseQuestion::class;
    }

    protected function getFormType()
    {
        return new BaseQuestionForm();
    }

    public function post(array $parameters)
    {
        $baseQuestion = new BaseQuestion();
        $baseQuestion->setCreatedBy($this->getUser());

        return $this->processForm($baseQuestion, $parameters, 'POST');
    }


}