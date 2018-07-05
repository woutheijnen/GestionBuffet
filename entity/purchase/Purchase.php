<?php

namespace Src\Entity\Purchase;

use Doctrine\ORM\Mapping as ORM;


/**
 * Purchase
 *
 * @ORM\Table(name="purchase")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Src\Entity\Purchase\PurchaseRepository")
 */
class Purchase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=255, nullable=false)
     */
    private $cuit;

    /**
     * @ORM\Column(name="path_of_scan", type="string", length=255, nullable=true)
     */
    private $path_of_scan;
 
    /**
     * @var string
     *
     * @ORM\Column(name="product_list", type="string", length=255, nullable=false)
     */
    private $product_list;
    
    /** @ORM\Column(type="datetime", nullable=true) */
    private $dateFrom;

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
     * Set cuit
     *
     * @param string $cuit
     *
     * @return Purchase
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }
    
    /**
     * Set path_of_scan
     *
     * @param string $path_of_scan
     *
     * @return Purchase
     */
    public function setPath_of_scan($path_of_scan)
    {
        $this->path_of_scan = $path_of_scan;

        return $this;
    }

    /**
     * Get path_of_scan
     *
     * @return string
     */
    public function getPath_of_scan()
    {
        return $this->path_of_scan;
    }

    /**
     * Set product_list
     *
     * @param string $product_list
     *
     * @return Purchase
     */
    public function setProduct_list($product_list)
    {
        $this->product_list = $product_list;

        return $this;
    }

    /**
     * Get product_list
     *
     * @return string
     */
    public function getProduct_list()
    {
        return $this->product_list;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Purchase
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }
}
