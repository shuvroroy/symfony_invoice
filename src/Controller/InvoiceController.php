<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use App\Repository\ProductRepository;
use App\Service\UniqueNumberGenerator;
use App\Utils\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/invoice")
 */
class InvoiceController extends AbstractController
{
    /**
     * @Route("/", name="invoice_index", methods={"GET"})
     */
    public function index(InvoiceRepository $invoiceRepository, Serializer $serializer)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $jsonInvoices = $serializer->serialize($invoiceRepository->findAll(), 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->render('invoice/index.html.twig', [
            'invoices' => $jsonInvoices
        ]);
    }

    /**
     * @Route("/new", name="invoice_new", methods={"GET","POST"})
     */
    public function new(Request $request, InvoiceRepository $invoiceRepository, UniqueNumberGenerator $uniqueNumberGenerator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setNumber($uniqueNumberGenerator->getUniqueNumber());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoice);
            $entityManager->flush();

            $this->addFlash('success', 'You just create your invoice successfully.');

            return $this->redirectToRoute('invoice_index');
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="invoice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Invoice $invoice): Response
    {
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('invoice_index');
        }

        return $this->render('invoice/edit.html.twig', [
            'product' => $invoice,
            'form' => $form->createView(),
        ]);
    }
}
