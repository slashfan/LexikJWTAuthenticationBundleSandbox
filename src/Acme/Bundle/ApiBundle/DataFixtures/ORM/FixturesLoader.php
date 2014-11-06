<?php

namespace Acme\Bundle\ApiBundle\DataFixtures\ORM;

use Acme\Bundle\ApiBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * FixturesLoader
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class FixturesLoader implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('dbuser');
        $user->setEmail('dbuser@acme.tld');

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword('password', $user->getSalt()));

        $manager->persist($user);
        $manager->flush();
    }
} 
