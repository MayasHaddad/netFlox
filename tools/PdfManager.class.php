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

    public function getPdf($contentString)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(40, 10, $contentString);
        $pdf->Output();   
    }
}