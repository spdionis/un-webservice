<?php


namespace AppBundle\Form;


use AppBundle\Entity\Course;
use AppBundle\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('course', 'entity', [
                'class' => Course::class,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }


    public function getName()
    {
        return 'module_form';
    }
}