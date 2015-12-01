<?php


namespace AppBundle\Handler;


use AppBundle\Entity\Course;
use AppBundle\Form\CourseForm;

class CourseHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Course::class;
    }

    protected function getFormType()
    {
        return new CourseForm();
    }
}