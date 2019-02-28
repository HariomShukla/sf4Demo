<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $categoryName;
	
	
	 /**
     * One Category has One Product.
	 * @ORM\OneToOne(targetEntity="Product", inversedBy="category")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        // set (or unset) the owning side of the relation if necessary
        $newCategory = $products === null ? null : $this;
        if ($newCategory !== $products->getCategory()) {
            $products->setCategory($newCategory);
        }

        return $this;
    }

    
	

    
	
	
	
}
