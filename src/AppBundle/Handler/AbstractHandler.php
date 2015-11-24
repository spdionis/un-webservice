<?php


namespace AppBundle\Handler;


use AppBundle\Exception\InvalidFormException;
use AppBundle\Helper\FilterHelper;
use AppBundle\Helper\PaginateHelper;
use AppBundle\Helper\SortHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var User
     */
    protected $user;

    /**
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * @return FormTypeInterface
     */
    abstract protected function getFormType();

    /**
     * @return FormTypeInterface
     */
    protected function getSearchFormType()
    {
        throw new \RuntimeException('Search form type not implemented.');
    }

    /**
     * @param $page
     * @param int $perPage
     * @param array $orderBy
     * @param QueryBuilder $qb
     *
     * @return Paginator
     */
    public function getPaginated($page, $perPage = PaginateHelper::DEFAULT_PER_PAGE, array $orderBy = [], QueryBuilder $qb = null)
    {
        $qb = $qb ?: $this->repository->createQueryBuilder('a');

        $qb = PaginateHelper::apply($qb, $page, $perPage);

        if ($this->isOwned() && $this->getUser()) {
            $owner = $this->getUser();
            $qb->andWhere('a.user = :user')
                ->setParameter('user', $owner);
        }

        $qb = SortHelper::apply($qb, $orderBy);

        $paginator = new Paginator($qb, true);

        return $paginator;
    }

    /**
     * @param array $parameters
     *
     * @return object
     *
     * @throws InvalidFormException
     */
    public function post(array $parameters)
    {
        $class = $this->getEntityClass();
        $entity = new $class();

        return $this->processForm($entity, $parameters, 'POST');
    }

    /**
     * @param array $parameters
     * @param object $entity
     *
     * @return object
     */
    public function patch(array $parameters, $entity)
    {
        return $this->processForm($entity, $parameters, 'PATCH');
    }

    /**
     * @param object $entity
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function search(array $parameters, $page, $perPage = PaginateHelper::DEFAULT_PER_PAGE, array $orderBy = [])
    {
        $form = $this->formFactory->create($this->getSearchFormType());
        $form->submit($parameters);
        if (!$form->isValid()) {
            throw new InvalidFormException($form);
        }

        $removeNulls = function ($val) use (&$removeNulls) {
            if (is_array($val)) {
                return array_filter($val, $removeNulls) !== [];
            }

            return $val !== null && $val !== '';
        };

        $parameters = array_filter($form->getData(), $removeNulls);
        $qb = $this->repository->createQueryBuilder('a');

        $qb = FilterHelper::apply($qb, $parameters);

        return $this->getPaginated($page, $perPage, $orderBy, $qb);
    }

    /**
     * @param object $entity
     * @param array $parameters
     * @param $method
     *
     * @return object
     *
     * @throws InvalidFormException
     */
    protected function processForm($entity, array $parameters, $method)
    {
        $form = $this->formFactory->create($this->getFormType(), $entity, ['method' => $method]);
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $entity = $form->getData();

            if ($this->isOwned() && !$entity->getUser()) {
                $entity->setUser($this->getUser());
            }

            $this->save($entity);

            return $entity;
        }

        throw new InvalidFormException($form);
    }

    /**
     * @param $entity
     */
    protected function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    protected function isOwned()
    {
//        return in_array(OwnedEntityInterface::class, class_implements($this->getEntityClass()));
        return false;
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        $this->user = $this->user ?: $this->tokenStorage->getToken()->getUser();

        return $this->user;
    }

    /**
     * @param EntityManagerInterface $em
     *
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($this->getEntityClass());
    }

    /**
     * @param FormFactoryInterface $formFactory
     *
     * @return $this
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     *
     * @return $this
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

}