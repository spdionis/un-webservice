<?php


namespace AppBundle\Form;


use AppBundle\Entity\BaseQuestion;
use AppBundle\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseQuestionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea')
            ->add('enabled', 'checkbox')
            ->add('topic', 'entity', [
                'class' => Topic::class,
            ])
            ->add('type', 'choice', [
                'choices' => array_combine(BaseQuestion::getTypes(), BaseQuestion::getTypes()),
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BaseQuestion::class,
        ]);
    }


    public function getName()
    {
        return 'base_question_form';
    }

}