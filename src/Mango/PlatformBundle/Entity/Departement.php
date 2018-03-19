<?php

namespace Mango\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement")
 * @ORM\Entity(repositoryClass="Mango\PlatformBundle\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="dep_code", type="string", length=5)
     */
    private $dep_code;

    /**
    * @ORM\ManyToOne(targetEntity="Mango\PlatformBundle\Entity\Region")
    */
    private $region;

    /**
    * @ORM\OneToMany(targetEntity="Mango\PlatformBundle\Entity\City", mappedBy="departement")
    */
    private $cities;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Departement
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set depCode
     *
     * @param string $depCode
     *
     * @return Departement
     */
    public function setDepCode($depCode)
    {
        $this->dep_code = $depCode;

        return $this;
    }

    /**
     * Get depCode
     *
     * @return string
     */
    public function getDepCode()
    {
        return $this->dep_code;
    }

    /**
     * Set region
     *
     * @param \Mango\PlatformBundle\Entity\Region $region
     *
     * @return Departement
     */
    public function setRegion(\Mango\PlatformBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Mango\PlatformBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add city
     *
     * @param \Mango\PlatformBundle\Entity\City $city
     *
     * @return Departement
     */
    public function addCity(\Mango\PlatformBundle\Entity\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \Mango\PlatformBundle\Entity\City $city
     */
    public function removeCity(\Mango\PlatformBundle\Entity\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {

        return $this->cities;
    }

    public function __toString()
    {
        return $this->name;
    }
}
