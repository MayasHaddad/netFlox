<?php
/**
* This class manages all the PDF related treatments
* @author Mayas Haddad
*/
class PdfManager
{
    function __construct()
    {

    }

     public function getCataloguePdf($header, $moviesData)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->BasicTable($header, $moviesData);
        $pdf->Output();   
    }
    public function getAuditPdf($header, $customerData, $period, $turnover)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->BasicTable($header, $customerData);
        $pdf->AddPage();
        $pdf->Cell(40, 10, 'Depuis le '. $period . 'votre chiffre d\'affaires est de : ' . $turnover);
        //$pdf->Cell(40, 10, $contentString);
        $pdf->Output();   
    }
}