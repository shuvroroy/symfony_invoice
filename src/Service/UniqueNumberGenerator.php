<?php

namespace App\Service;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;

class UniqueNumberGenerator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUniqueNumber()
    {
        $randomInvoiceNumber = rand(111111, 999999);

        $invoice = $this->entityManager
            ->getRepository(Invoice::class)
            ->findOneBy(['number' => $randomInvoiceNumber]);

        if ($invoice) {
            $this->getUniqueNumber();
        }

        return $randomInvoiceNumber;
    }
}