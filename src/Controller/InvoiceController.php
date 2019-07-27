<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
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
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }

    /**
     * @Route("/new", name="invoice_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('invoice_index');
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form->createView(),
        ]);
    }
}
