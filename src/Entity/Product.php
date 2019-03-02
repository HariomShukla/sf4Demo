<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
	 * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
	 * @Assert\NotBlank
     */
    private $stockAvailable;

    /**
     * @ORM\Column(name="status", type="string", columnDefinition="enum('In Stock', 'Out Of Stock', 'Pre Order')")
	 * @Assert\NotBlank
     */
    private $status;

    
	#/**
    # * One Product has One Category.
    # * @ORM\OneToOne(targetEntity="Category", mappedBy="products")
    # */
    #private $category;
	
	/**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
	 * @Assert\NotBlank
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStockAvailable(): ?int
    {
        return $this->stockAvailable;
    }

    public function setStockAvailable(int $stockAvailable): self
    {
        $this->stockAvailable = $stockAvailable;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
	
	public function __toString()
	{
		return $this->name;
	}
	
	
	

   
}
