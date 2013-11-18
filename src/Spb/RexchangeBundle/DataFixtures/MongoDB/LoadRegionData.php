<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.11.13
 * Time: 19:34
 */

namespace Spb\RexchangeBundle\DataFixtures\MongoDB;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Spb\RexchangeBundle\Document\Region;
use Spb\RexchangeBundle\Document\District;
use Spb\RexchangeBundle\Document\Subway;

class LoadRegionData implements  FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $spb = new Region();
        $spb->setId(40);
        $spb->setName('Санкт-Петербург');

        $spb_district = new District();
        $spb_district->setId(1);
        $spb_district->setName('dfd');
        $spb->addDistrict($spb_district);
/*
        $spb_subway = new Subway();
        $spb_subway->setId(1);
        $spb_subway->setName('sdf');
        $spb->addSubway($spb_subway);
*/

        $manager->persist($spb);

        $manager->flush();
    }

}