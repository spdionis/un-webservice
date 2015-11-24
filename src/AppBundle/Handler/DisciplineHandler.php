<?php


namespace AppBundle\Handler;


use AppBundle\Entity\Discipline;
use AppBundle\Form\DisciplineForm;

class DisciplineHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Discipline::class;
    }

    protected function getFormType()
    {
        return new DisciplineForm();
    }
}