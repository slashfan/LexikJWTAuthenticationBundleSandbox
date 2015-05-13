<?php

namespace Acme\Bundle\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\Bundle\ApiBundle\Entity\User;

/**
 * LoadUserData
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        $user->setUsername('fosuser');
        $user->setEmail('fosuser@test.tld');
        $user->setPlainPassword('password');
        $user->setEnabled(true);

        $this->container->get('fos_user.user_manager')->updatePassword($user);

        $manager->persist($user);
        $manager->flush();
    }
}
