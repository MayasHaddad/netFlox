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
        $moviesString = "";
        foreach ($moviesData as $key => $movie) 
        {
            foreach ($movie as $key1 => $value) 
            {
                $pdf->MultiCell(180, 10, $key1 . ' : ' . $value);
                $pdf->Ln();
            }  
            $pdf->AddPage();  
        }
        $pdf->Output();
    }

    public function getAuditPdf($header, $customerData, $period, $turnover)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->BasicTable($header, $customerData, array('id_customer'));
        $pdf->AddPage();
        $pdf->Cell(40, 10, 'Depuis le '. $period . ' votre chiffre d\'affaires est de : ' . $turnover);
        //$pdf->Cell(40, 10, $contentString);
        $pdf->Output();   
    }
}