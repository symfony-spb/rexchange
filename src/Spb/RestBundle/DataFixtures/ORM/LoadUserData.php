<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.11.13
 * Time: 19:34
 */

namespace Spb\RestBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Spb\RestBundle\Entity\User;

class LoadUserData implements  FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $alice = new User();
        $alice->setUsername('alice');
        $alice->setEmail('manilo@mail.ru');
        $alice->setPassword('n0ne');

        $den = new User();
        $den->setUsername('denis');
        $den->setEmail('denis@symfony.spb.ru');
        $den->setPassword('n0ne');

        $manager->persist($alice);
        $manager->persist($den);

        $manager->flush();
    }

} 