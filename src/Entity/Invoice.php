<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
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
     */
    private $number;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="date")
     */
    private $due_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="float")
     */
    private $sub_total;

    /**
     * @ORM\Column(type="float")
     */
    private $discount;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceItem", mappedBy="invoice", orphanRemoval=true)
     */
    private $invoiceItems;

    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeInterface $due_date): self
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getSubTotal(): ?float
    {
        return $this->sub_total;
    }

    public function setSubTotal(float $sub_total): self
    {
        $this->sub_total = $sub_total;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|InvoiceItem[]
     */
    public function getInvoiceItems(): Collection
    {
        return $this->invoiceItems;
    }

    public function addInvoiceItem(InvoiceItem $invoiceItem): self
    {
        if (!$this->invoiceItems->contains($invoiceItem)) {
            $this->invoiceItems[] = $invoiceItem;
            $invoiceItem->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceItem(InvoiceItem $invoiceItem): self
    {
        if ($this->invoiceItems->contains($invoiceItem)) {
            $this->invoiceItems->removeElement($invoiceItem);
            // set the owning side to null (unless already changed)
            if ($invoiceItem->getInvoice() === $this) {
                $invoiceItem->setInvoice(null);
            }
        }

        return $this;
    }
}
