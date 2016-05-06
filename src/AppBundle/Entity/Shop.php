<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ShopRepository")
 * @ORM\Table(name="shop")
 */
class Shop {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiUri;
    /**
     * @ORM\Column(type="datetime")
     */
    private $lastImportTime;
    
    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="shopId")
     */
    private $orders;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Shop
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
     * Set apiUri
     *
     * @param string $apiUri
     *
     * @return Shop
     */
    public function setApiUri($apiUri)
    {
        $this->apiUri = $apiUri;

        return $this;
    }

    /**
     * Get apiUri
     *
     * @return string
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * Set setLastImportTime
     *
     * @param \DateTime $lastImportTime
     *
     * @return Shop
     */
    public function setLastImportTime($lastImportTime)
    {
        $this->lastImportTime = $lastImportTime;

        return $this;
    }

    /**
     * Get lastExportTime
     *
     * @return \DateTime
     */
    public function getLastImportTime()
    {
        return $this->lastImportTime;
    }


    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Shop
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

}
