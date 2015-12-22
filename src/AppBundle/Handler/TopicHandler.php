<?php


namespace AppBundle\Handler;


use AppBundle\Entity\Topic;
use AppBundle\Form\TopicForm;

class TopicHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Topic::class;
    }

    protected function getFormType()
    {
        return new TopicForm();
    }

}