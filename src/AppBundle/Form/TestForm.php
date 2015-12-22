<?php


namespace AppBundle\Form;


use AppBundle\Entity\Test;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'choices' => array_combine(Test::getTypes(), Test::getTypes()),
            ])
            ->add('duration', 'integer');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }


    public function getName()
    {
        return 'test_form';
    }

}