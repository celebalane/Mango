<?php

namespace Mango\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSUser;

/**
 * User
 *
 * @ORM\Table(name="mango_user")
 * @ORM\Entity(repositoryClass="Mango\UserBundle\Repository\UserRepository")
 */
class User extends FOSUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="rent_id", type="integer", nullable=true)
     */
    private $rentId;

    /**
     * @var int
     *
     * @ORM\Column(name="buy_id", type="integer", nullable=true)
     */
    private $buyId;

    public function __construct(){
    	parent::__construct();
    }



    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set rentId
     *
     * @param integer $rentId
     *
     * @return User
     */
    public function setRentId($rentId)
    {
        $this->rentId = $rentId;

        return $this;
    }

    /**
     * Get rentId
     *
     * @return integer
     */
    public function getRentId()
    {
        return $this->rentId;
    }

    /**
     * Set buyId
     *
     * @param integer $buyId
     *
     * @return User
     */
    public function setBuyId($buyId)
    {
        $this->buyId = $buyId;

        return $this;
    }

    /**
     * Get buyId
     *
     * @return integer
     */
    public function getBuyId()
    {
        return $this->buyId;
    }
}
