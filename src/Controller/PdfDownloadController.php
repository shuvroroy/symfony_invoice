<?php

namespace App\Controller;

use App\Entity\Invoice;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PdfDownloadController extends AbstractController
{
    /**
     * @Route("/invoices/{id}/download", name="invoice_download")
     */
    public function index(Invoice $invoice)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('invoice/invoice_pdf.html.twig', [
            'invoice' => $invoice
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream(rand(10000, 90000) .".pdf", [
            "Attachment" => true
        ]);
    }
}
