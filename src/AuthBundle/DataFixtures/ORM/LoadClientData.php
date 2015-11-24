<?php

namespace AuthBundle\DataFixtures\ORM;

use AuthBundle\Entity\Client;
use AuthBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadClientData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $clientManager = $this->container->get('fos_oauth_server.client_manager');

        /** @var Client $client */
        $client = $clientManager->createClient();
        $client->setRedirectUris([]);
        $client->setAllowedGrantTypes(['password', 'refresh_token']);
        $client->setRandomId('random_id');
        $client->setSecret('secret');

        $manager->persist($client);

        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUsername('test');

        $encoderFactory = $this->container->get('security.encoder_factory');
        $user->setPassword($encoderFactory->getEncoder($user)->encodePassword('test', $user->getSalt()));

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
