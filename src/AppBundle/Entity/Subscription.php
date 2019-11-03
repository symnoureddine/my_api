<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubscriptionRepository")
 */
class Subscription
{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     */
     private $id;
    

    /**
     * 
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Contact")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    private $contact;

    /**
     * 
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(name="begin_date", type="datetime",nullable=true)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $beginDate;

    /**
     *
     * @ORM\Column(name="end_date", type="datetime",nullable=true)
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     */
    private $endDate;


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
     * Get the value of contact
     */ 
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set the value of contact
     *
     * @return  self
     */ 
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get the value of product
     */ 
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the value of product
     *
     * @return  self
     */ 
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get the value of beginDate
     */ 
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set the value of beginDate
     *
     * @return  self
     */ 
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }
}