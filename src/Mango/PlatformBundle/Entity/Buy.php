<?php

namespace Mango\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Buy
 *
 * @ORM\Table(name="buy")
 * @ORM\Entity(repositoryClass="Mango\PlatformBundle\Repository\BuyRepository")
 */
class Buy
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_parts", type="integer")
     */
    private $nbParts;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
    * @ORM\OneToOne(targetEntity="Mango\PlatformBundle\Entity\Image", cascade={"persist"})
    */
    private $image;
    
    /**
    * @ORM\ManyToOne(targetEntity="Mango\PlatformBundle\Entity\Region", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $region;

    /**
    * @ORM\ManyToOne(targetEntity="Mango\PlatformBundle\Entity\Departement", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $departement;

    /**
    * @ORM\ManyToOne(targetEntity="Mango\PlatformBundle\Entity\City", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $city;

    /**
    * @ORM\ManyToOne(targetEntity="Mango\PlatformBundle\Entity\Type", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $type;


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
     * Set title
     *
     * @param string $title
     *
     * @return Buy
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Buy
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Buy
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Buy
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Buy
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Buy
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Buy
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \Mango\PlatformBundle\Entity\Image $image
     *
     * @return Buy
     */
    public function setImage(\Mango\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Mango\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set region
     *
     * @param \Mango\PlatformBundle\Entity\Region $region
     *
     * @return Buy
     */
    public function setRegion(\Mango\PlatformBundle\Entity\Region $region)
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
     * Set departement
     *
     * @param \Mango\PlatformBundle\Entity\Departement $departement
     *
     * @return Buy
     */
    public function setDepartement(\Mango\PlatformBundle\Entity\Departement $departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \Mango\PlatformBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set city
     *
     * @param \Mango\PlatformBundle\Entity\City $city
     *
     * @return Buy
     */
    public function setCity(\Mango\PlatformBundle\Entity\City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Mango\PlatformBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set type
     *
     * @param \Mango\PlatformBundle\Entity\Type $type
     *
     * @return Buy
     */
    public function setType(\Mango\PlatformBundle\Entity\Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Mango\PlatformBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set nbParts
     *
     * @param integer $nbParts
     *
     * @return Buy
     */
    public function setNbParts($nbParts)
    {
        $this->nbParts = $nbParts;

        return $this;
    }

    /**
     * Get nbParts
     *
     * @return integer
     */
    public function getNbParts()
    {
        return $this->nbParts;
    }
}
