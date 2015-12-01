<?php


namespace AppBundle\Handler;



use AppBundle\Entity\Module;
use AppBundle\Form\ModuleForm;

class ModuleHandler extends AbstractHandler
{
    protected function getEntityClass()
    {
        return Module::class;
    }

    protected function getFormType()
    {
        return new ModuleForm();
    }

}