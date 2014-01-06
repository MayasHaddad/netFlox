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

    public function getPdf($header, $data)
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',10);
        $pdf->BasicTable($header, $data);
        //$pdf->Cell(40, 10, $contentString);
        $pdf->Output();   
    }
}