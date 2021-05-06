<?php
require "fpdf.php";

class PDF extends FPDF
{
    private string $title;
    private int $titleX;

    public function __construct($orientation, $unit, $size, $title)
    {
        parent::__construct($orientation, $unit, $size);
        $this->titleX = $orientation == 'L' ? 200 : 125;
        $this->title = $title;
    }

    function Header()
    {
        $this->Image("../img/tesla_t.png", 2, 2, 27, 25);
        $this->SetFont('Arial','B',15);
        $this->Cell(30);
        $this->Cell($this->titleX,10, $this->title,0,0,'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I', 8);
        $this->Cell(0,10, $this->PageNo().'/{nb}',0,0,'C' );
    }
}