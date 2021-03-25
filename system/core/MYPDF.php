<?php

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    private $subtitle,$location, $name,$date;

    function __construct($subtitle, $name,$location,$date, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->subtitle = $subtitle;
        $this->name = $name;
        $this->location=$location;
        $this->date=$date;
    }

    //Page header
    public function Header() {
        //TODAY
       // $date= date('d/m/Y H:i:s', time());
        $this->Cell(180, 0, $this->date , 0, 1, 'R');
        // Logo
        $image_file = K_PATH_IMAGES . 'coat.png';
        $html = '<div style="text-align:center"><img src="' . $image_file . '" height="50" width="50" align="center"/></div>';

        $this->writeHTML($html, true, 0, true, true);

        
        
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 13, 'FEDERAL REPUBLIC OF NIGERIA', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        // Set font
        $this->SetFont('times', 'B', 14);
        $this->Cell(0, 13, $this->subtitle, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('times', 'B', 13);
        $this->Cell(0, 13, $this->name, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 13, 'ENROLMENT SLIP', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(180, 0, "LOCATION:$this->location " , 0, 1, 'R');
                
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    
}
