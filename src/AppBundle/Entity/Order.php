<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Shop", inversedBy="orders")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id") 
     */
    private $shopId;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $importShopId;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $orderId;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $orderPayment;
    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

  

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
     * Set importShopId
     *
     * @param integer $importShopId
     *
     * @return Order
     */
    public function setImportShopId($importShopId)
    {
        $this->importShopId = $importShopId;

        return $this;
    }

    /**
     * Get importShopId
     *
     * @return integer
     */
    public function getImportShopId()
    {
        return $this->importShopId;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Order
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set orderPayment
     *
     * @param string $orderPayment
     *
     * @return Order
     */
    public function setOrderPayment($orderPayment)
    {
        $this->orderPayment = $orderPayment;

        return $this;
    }

    /**
     * Get orderPayment
     *
     * @return string
     */
    public function getOrderPayment()
    {
        return $this->orderPayment;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Order
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {   
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set shopId
     *
     * @param \AppBundle\Entity\Shop $shopId
     *
     * @return Order
     */
    public function setShopId(\AppBundle\Entity\Shop $shopId = null)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * Get shopId
     *
     * @return \AppBundle\Entity\Shop
     */
    public function getShopId()
    {
        return $this->shopId;
    }
}
