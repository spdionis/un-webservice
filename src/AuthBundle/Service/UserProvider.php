<?php


namespace AuthBundle\Service;


use AuthBundle\Entity\Repository\UserRepository;
use AuthBundle\Entity\User;
use Doctrine\ORM\UnexpectedResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        try {
            return $this->userRepository->findOneByUsername($username);
        } catch (UnexpectedResultException $e) {
            throw new UsernameNotFoundException();
        }
    }

    public function refreshUser(UserInterface $user)
    {
        if ($user instanceof User) {
            $this->userRepository->refreshUser($user);
        } else {
            throw new UnsupportedUserException();
        }
    }

    public function supportsClass($class)
    {
        return $class === User::class;
    }


}