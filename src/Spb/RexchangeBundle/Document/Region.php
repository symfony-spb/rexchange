<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 17.11.13
 * Time: 18:01
 */

namespace Spb\RexchangeBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * Class Region
 * @package Spb\RexchangeBundle\Document
 * @MongoDB\Document(collection="d01_region")
 */
class Region {
    /**
     * @MongoDB\Id(strategy="NONE")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /** @MongoDB\EmbedMany(targetDocument="District") */
    protected  $district = array();

    /** @MongoDB\EmbedMany(targetDocument="Subway") */
    protected  $subway = array();

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->district = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param custom_id $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * Add district
     *
     * @param \Spb\RexchangeBundle\Document\District $district
     */
    public function addDistrict(\Spb\RexchangeBundle\Document\District $district)
    {
        $this->district[] = $district;
    }

    /**
     * Remove district
     *
     * @param \Spb\RexchangeBundle\Document\District $district
     */
    public function removeDistrict(\Spb\RexchangeBundle\Document\District $district)
    {
        $this->district->removeElement($district);
    }

    /**
     * Get district
     *
     * @return \Doctrine\Common\Collections\Collection $district
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add subway
     *
     * @param \Spb\RexchangeBundle\Document\Subway $subway
     */
    public function addSubway(\Spb\RexchangeBundle\Document\Subway $subway)
    {
        $this->subway[] = $subway;
    }

    /**
     * Remove subway
     *
     * @param \Spb\RexchangeBundle\Document\Subway $subway
     */
    public function removeSubway(\Spb\RexchangeBundle\Document\Subway $subway)
    {
        $this->subway->removeElement($subway);
    }

    /**
     * Get subway
     *
     * @return \Doctrine\Common\Collections\Collection $subway
     */
    public function getSubway()
    {
        return $this->subway;
    }
}
