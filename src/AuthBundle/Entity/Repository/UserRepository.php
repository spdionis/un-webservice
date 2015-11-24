<?php


namespace AuthBundle\Entity\Repository;


use AuthBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * @method User|null findOneByUsername($username)
 */
class UserRepository extends EntityRepository
{

    public function refreshUser(User $user)
    {
        $this->_em->refresh($user);
    }
}