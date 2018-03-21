<?php

namespace Mango\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rent
 *
 * @ORM\Table(name="rent")
 * @ORM\Entity(repositoryClass="Mango\PlatformBundle\Repository\RentRepository")
 */
class Rent
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
     * @Assert\Length(min=10, max=50, minMessage="Le titre doit faire au minimum 10 caractère", maxMessage="Le titre doit faire maximum 50 caractère")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\Range(min=0, max=99999, minMessage="Merci d'indiquer un prix", maxMessage="Le prix est maximum de 99999 €")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="charge", type="integer")
     * @Assert\Range(min=0, max=9999, minMessage="Merci d'indiquer un prix", maxMessage="Le prix est maximum de 9999 €")
     */
    private $charge;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     * @Assert\Range(min=0, max=999999, minMessage="Merci d'indiquer une superficie", maxMessage="La superficie est maximum de 999999 m²")
     */
    private $size;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_parts", type="integer")
     * @Assert\Range(min=0, max=99, minMessage="Merci d'indiquer le nombre de pièce", maxMessage="Le nombre de pièces maximum est de 99")
     */
    private $nbParts;

    /**
     * @var bool
     *
     * @ORM\Column(name="meuble", type="boolean")
     */
    private $meuble;

    /**
     * @var bool
     *
     * @ORM\Column(name="collocation", type="boolean")
     */
    private $collocation;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\Length(min=140, max=3000, minMessage="La description doit faire au minimum 140 caractères", 
     * maxMessage="La description doit faire maximum 3000 caractères")
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
    * @ORM\OneToOne(targetEntity="Mango\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
    * @Assert\Valid() 
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


    public function __construct()
    {
        $this->date = new \Datetime();
    }

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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
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
     * @return Rent
     */
    public function setImage(\Mango\PlatformBundle\Entity\Image $image)
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
     * Set city
     *
     * @param \Mango\PlatformBundle\Entity\City $city
     *
     * @return Rent
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
     * Set region
     *
     * @param \Mango\PlatformBundle\Entity\Region $region
     *
     * @return Rent
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
     * @return Rent
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
     * Set type
     *
     * @param \Mango\PlatformBundle\Entity\Type $type
     *
     * @return Rent
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
     * Set meuble
     *
     * @param boolean $meuble
     *
     * @return Rent
     */
    public function setMeuble($meuble)
    {
        $this->meuble = $meuble;

        return $this;
    }

    /**
     * Get meuble
     *
     * @return boolean
     */
    public function getMeuble()
    {
        return $this->meuble;
    }

    /**
     * Set nbParts
     *
     * @param integer $nbParts
     *
     * @return Rent
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

    /**
     * Set collocation
     *
     * @param boolean $collocation
     *
     * @return Rent
     */
    public function setCollocation($collocation)
    {
        $this->collocation = $collocation;

        return $this;
    }

    /**
     * Get collocation
     *
     * @return boolean
     */
    public function getCollocation()
    {
        return $this->collocation;
    }

    /**
     * Set charge
     *
     * @param integer $charge
     *
     * @return Rent
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return integer
     */
    public function getCharge()
    {
        return $this->charge;
    }
}
