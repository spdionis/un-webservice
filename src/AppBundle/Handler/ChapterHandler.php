<?php


namespace AppBundle\Handler;


use AppBundle\Entity\Chapter;
use AppBundle\Form\ChapterForm;

class ChapterHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Chapter::class;
    }

    protected function getFormType()
    {
        return new ChapterForm();
    }

}