<?php

namespace AuthBundle\Handler;

use AppBundle\Handler\AbstractHandler;
use AuthBundle\Entity\User;
use AuthBundle\Form\UserForm;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserHandler extends AbstractHandler
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @return string
     */
    protected function getEntityClass()
    {
        return User::class;
    }

    /**
     * @return FormTypeInterface
     */
    protected function getFormType()
    {
        return new UserForm();
    }

    /**
     * @param $entity
     */
    protected function save($entity)
    {
        if (isset($parameters['password'])) {
            $this->updatePassword($entity, $parameters['password']);
        }
        parent::save($entity);
    }

    /**
     * @param User $user
     * @param $password
     */
    private function updatePassword(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
    }
}
