<?php


namespace AuthBundle\Form;


use AppBundle\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddCourseToUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('course', 'entity', [
            'class' => Course::class,
        ]);
    }

    public function getName()
    {
        return 'add_course_to_user_form';
    }

}