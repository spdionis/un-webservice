<?php

namespace AP\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRolesForm extends AbstractType
{
    /**
     * @var array
     */
    private $roles = [];

    public function __construct(array $roles)
    {
        $this->roles = $this->flattenRoles($roles);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', 'choice', [
                'choices' => array_combine($this->roles, $this->roles),
                'multiple' => true,
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user_roles_form';
    }

    /**
     * Flattens roles array to get all possible roles.
     *
     * @param array $roles
     *
     * @return array
     */
    private function flattenRoles(array $roles)
    {
        $result = [];

        array_walk_recursive($roles, function ($val) use (&$result) {
            $result[] = $val;
        });

        return array_unique($result);
    }
}
