<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please enter product name.")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Please enter product description.")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $unit_price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceItem", mappedBy="product")
     */
    private $invoceItems;

    public function __construct()
    {
        $this->invoceItems = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    /**
     * @return Collection|InvoiceItem[]
     */
    public function getInvoceItems(): Collection
    {
        return $this->invoceItems;
    }

    public function addInvoceItem(InvoiceItem $invoceItem): self
    {
        if (!$this->invoceItems->contains($invoceItem)) {
            $this->invoceItems[] = $invoceItem;
            $invoceItem->setProduct($this);
        }

        return $this;
    }

    public function removeInvoceItem(InvoiceItem $invoceItem): self
    {
        if ($this->invoceItems->contains($invoceItem)) {
            $this->invoceItems->removeElement($invoceItem);
            // set the owning side to null (unless already changed)
            if ($invoceItem->getProduct() === $this) {
                $invoceItem->setProduct(null);
            }
        }

        return $this;
    }
}
