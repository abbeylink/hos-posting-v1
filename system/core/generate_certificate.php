<?php

class generate_certificate {

    var $table;
    var $com, $db;

    function __construct() {
        $this->table = 'staff_enroll';
        $this->com = new common();
        $this->db = new model_query();
        ;
    }

    /*
     * GENERATE EMPLOYEE SLIP
     */

    function generate_para_military_slip($refid, $broswer = 'true') {

        //Get Employee data
        $data = $this->db->get_data_($this->table, array("reference_id" => $refid, "account_no" => $refid, "phone_no" => $refid, "service_no" => $refid));
        //Location
        $loc = $data['location'];
        //Date Captured
        $date = $data['updated'];
        //GET EMPLOYEE SERVICE
        $service = $this->db->get_data('service', array('code' => $data['service']));

        // create new PDF document
        $pdf = new MYPDF($service['title'], $service['name'], $loc, $date, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set fonthelvetica
        $pdf->SetFont('helvetica', '', 10);

// define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $pdf->AddPage();

        $pdf->Ln(35);
        $pdf->write1DBarcode($data['reference_id'], 'C128', '', '', '', 18, 0.3, $style, 'N');
        $pdf->Ln(10);
        // $pdf->SetXY(15, 70);

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'PERSONAL DATA', 'TB', 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('times', 'B', 11);
        $pdf->Image($data["img"], '160', '100', '40', '35');
        $pdf->Cell(50, 0, "SURNAME", 0, 0, 'L');
        $pdf->Cell(50, 0, "FIRST NAME", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "LAST NAME", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['surname'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['first_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['other_name'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "GENDER", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF BIRTH", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "MARITAL STATUS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['sex'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['date_of_birth'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['marital_status'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, " STATE OF ORIGIN", 0, 0, 'L');
        $pdf->Cell(50, 0, "LOCAL GOVT AREA", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "STATE OF RESIDENCE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['state_of_origin'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['local_govt_area'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['state_of_resident'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);

        $pdf->Cell(50, 0, "PHONE NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "E-MAIL ADDRESS", 0, 0, 'L');
        $pdf->Cell(50, 0, " RESIDENTIAL ADDRESS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['phone_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['email_address'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['residential_address'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'SERVICE RECORD', 'TB', 1, 'C');
        $pdf->Ln(6);

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "SERVICE NO ", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF ENLISTMENT", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF LAST PROMOTION", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['service_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['date_of_commission'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['last_promotion_date'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "GRADE LEVEL", 0, 0, 'L');
        $pdf->Cell(50, 0, "STEP", 0, 0, 'L');
        $pdf->Cell(50, 0, "SALARY STRUCTURE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['gl'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['step'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['salary_structure'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "PAY POINT", 0, 0, 'L');
        $pdf->Cell(50, 0, "RANK", 0, 0, 'L');
        $pdf->Cell(50, 0, "CADRE (OTHER RANKS)", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['pay_point'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['rank'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['cadre'], 0, 1, 0, 0, '', '', true);

        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "SKILL/TRADE", 0, 0, 'L');
        $pdf->Cell(50, 0, "PROFESSION", 0, 0, 'L');
        $pdf->Cell(50, 0, "COMMAND", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['skill'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['profession'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['command'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'BANK DETAILS', 'TB', 1, 'C');
        $pdf->Ln(6);
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(70, 0, "NAME OF BANK", 0, 0, 'L');
        $pdf->Cell(70, 0, "ACCOUNT NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(70, 0, "BVN", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(70, 0, $data['bank_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['account_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['bvn'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(70, 0, "PFA NAME", 0, 0, 'L');
        $pdf->Cell(70, 0, "PFA PIN", 0, 1, 'L'); //: : 
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(70, 0, $data['pfa_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['pfa_pin'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln(20);
        $pdf->SetFont('', 'B', 12);
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of Employee', 'T', 'L', 0, 0, '', '', true);
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date&Name of Enrolment Officer', 'T', 0, 0, 0, '', '', true);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of OAGF Team Leader.', 'T', 'L', 0, 0, '', '', true);

        ob_end_clean();
//$pdf->writeHTML("<hr>", true, false, false, false, '');
// DREAW LINE
        //  
// ---------------------------------------------------------
//Close and display output PDF document onbrwser
        // if ($broswer) {
        $pdf->Output('Employee Certificate.pdf', 'I');
//        } else {
//            $pdffile = $pdf->Output('Employee Certificate.pdf', 'S');
//            return $pdffile;
//        }
    }

    /*
     * GENERATE EMPLOYEE SLIP
     */

    function generate_military_slip($refid) {
        //Get Employee data
        $data = $this->db->get_data_($this->table, array("reference_id" => $refid, "account_no" => $refid, "phone_no" => $refid));
        //Location
        $loc = $data['location'];
        //Date Captured
        $date = $data['updated'];
        //GET EMPLOYEE SERVICE
        $service = $this->db->get_data('service', array('code' => $data['service']));

        // create new PDF document
        $pdf = new MYPDF($service['title'], $service['name'], $loc, $date, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set fonthelvetica
        $pdf->SetFont('helvetica', '', 10);



// define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $pdf->AddPage();

        $pdf->Ln(35);
        $pdf->write1DBarcode($data['reference_id'], 'C128', '', '', '', 18, 0.3, $style, 'N');
        $pdf->Ln(10);
        // $pdf->SetXY(15, 70);
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'PERSONAL DATA', 'TB', 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('times', 'B', 11);
        $pdf->Image($data["img"], '160', '100', '40', '35');
        $pdf->Cell(50, 0, "SURNAME", 0, 0, 'L');
        $pdf->Cell(50, 0, "FIRST NAME", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "LAST NAME", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['surname'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['first_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['other_name'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "GENDER", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF BIRTH", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "MARITAL STATUS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['sex'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['date_of_birth'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['marital_status'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, " STATE OF ORIGIN", 0, 0, 'L');
        $pdf->Cell(50, 0, "LOCAL GOVT AREA", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "STATE OF RESIDENCE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['state_of_origin'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['local_govt_area'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['state_of_resident'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);

        $pdf->Cell(50, 0, "PHONE NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "E-MAIL ADDRESS", 0, 0, 'L');
        $pdf->Cell(50, 0, " RESIDENTIAL ADDRESS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['phone_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['email_address'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['residential_address'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'SERVICE RECORD', 'TB', 1, 'C');
        $pdf->Ln(6);

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "SERVICE NO ", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF ENLISTMENT", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF LAST PROMOTION", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['service_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['date_of_commission'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['last_promotion_date'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "GRADE LEVEL", 0, 0, 'L');
        $pdf->Cell(50, 0, "STEP", 0, 0, 'L');
        $pdf->Cell(50, 0, "SALARY STRUCTURE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['gl'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['step'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['salary_structure'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "SKILL/TRADE", 0, 0, 'L');
        $pdf->Cell(50, 0, "RANK", 0, 0, 'L');
        $pdf->Cell(50, 0, "CADRE (OTHER RANKS)", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['skill'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['rank'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['cadre'], 0, 1, 0, 0, '', '', true);

        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "PAY POINT", 0, 0, 'L');
        $pdf->Cell(50, 0, "PROFESSION", 0, 0, 'L');
        $pdf->Cell(50, 0, "COMMAND", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['pay_point'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['profession'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['command'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'BANK DETAILS', 'TB', 1, 'C');
        $pdf->Ln(6);
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(70, 0, "NAME OF BANK", 0, 0, 'L');
        $pdf->Cell(70, 0, "ACCOUNT NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(70, 0, "BVN", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(70, 0, $data['bank_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['account_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['bvn'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
//        $pdf->Cell(70, 0, "PFA NAME", 0, 0, 'L');
//        $pdf->Cell(70, 0, "PFA PIN", 0, 1, 'L'); //: : 
//        $pdf->SetFont('times', '', 11);
//        $pdf->MultiCell(70, 0, $data['pfa_name'], 0, 1, 0, 0, '', '', true);
//        $pdf->MultiCell(70, 0, $data['pfa_pin'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln(20);
        $pdf->SetFont('', 'B', 12);
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of Employee', 'T', 'L', 0, 0, '', '', true);
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date&Name of Enrolment Officer', 'T', 0, 0, 0, '', '', true);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of OAGF Team Leader.', 'T', 'L', 0, 0, '', '', true);
//$pdf->writeHTML("<hr>", true, false, false, false, '');
// DREAW LINE
        //  Clear buffer
        ob_end_clean();
// ---------------------------------------------------------
//Close and display output PDF document onbrwser

        $pdf->Output('Employee Certificate.pdf', 'I');
    }

    /*
     * GENERATE EMPLOYEE SLIP
     */

    function generate_civilian_slip($refid) {

        //Get Employee data
        $data = $this->db->get_data_($this->table, array("reference_id" => $refid, "account_no" => $refid, "phone_no" => $refid));
        //Location
        $loc = $data['location'];
        //Date Captured
        $date = $data['created'];
        //GET EMPLOYEE SERVICE
        $service = $this->db->get_data('service', array('code' => $data['service']));

        // create new PDF document
        $pdf = new MYPDF($service['title'], $service['name'], $loc, $date, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set fonthelvetica
        $pdf->SetFont('helvetica', '', 10);

// define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
// $pdf->SetXY(15, 70);
        $pdf->AddPage();

        $pdf->Ln(35);
        $pdf->write1DBarcode($data['reference_id'], 'C128', '', '', '', 18, 0.3, $style, 'N');
        $pdf->Ln(5);

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'PERSONAL DATA', 'TB', 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('times', 'B', 11);
        if ($data['service'] === 'POLY' || $data['service'] === 'UNI') {
            $pdf->Cell(50, 0, "STAFF CATEGORY", 0, 0, 'L');
        }
        $pdf->Cell(50, 0, "TITLE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['title'], 0, 1, 0, 0, '', '', true);
        if ($data['service'] === 'POLY' || $data['service'] === 'UNI') {
            $pdf->MultiCell(50, 0, $data['staff_category'], 0, 1, 0, 0, '', '', true);
        }
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Image($data["img"], '160', '95', '40', '35');
        $pdf->Cell(50, 0, "SURNAME", 0, 0, 'L');
        $pdf->Cell(50, 0, "FIRST NAME", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "LAST NAME", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['surname'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['first_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['other_name'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "GENDER", 0, 0, 'L');
        $pdf->Cell(50, 0, "DATE OF BIRTH", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "MARITAL STATUS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['sex'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['date_of_birth'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['marital_status'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, " STATE OF ORIGIN", 0, 0, 'L');
        $pdf->Cell(50, 0, "LOCAL GOVT AREA", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "STATE OF RESIDENCE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['state_of_origin'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['local_govt_area'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(50, 0, $data['state_of_resident'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(50, 0, "L.G.A OF RESIDENCE", 0, 0, 'L');
        $pdf->Cell(50, 0, "PHONE NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(50, 0, "E-MAIL ADDRESS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(50, 0, $data['resident_lga'], 0, 1, 0, 0, '', '', true);
        $pdf->Cell(50, 0, $data['phone_no'], 0, 0, 'L');
        $pdf->MultiCell(50, 0, strtolower($data['email_address']), 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(80, 0, "PERMANENT ADDRESS", 0, 0, 'L'); //: : 
        $pdf->Cell(70, 0, " RESIDENTIAL ADDRESS", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(80, 0, $data['permanent_address'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['residential_address'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'SERVICE RECORD', 'TB', 1, 'C');
        $pdf->Ln(2);

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(55, 0, "1ST APPOINTMENT DATE", 0, 0, 'L');
        $pdf->Cell(55, 0, "LAST PROMOTION DATE", 0, 0, 'L');
        $pdf->Cell(40, 0, "SALARY STRUCTURE", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(55, 0, $data['date_of_commission'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(55, 0, $data['last_promotion_date'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(40, 0, $data['salary_structure'], 0, 1, 0, 0, '', '', true);

        $pdf->Ln(); //

        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(35, 0, "GRADE LEVEL", 0, 0, 'L');
        $pdf->Cell(25, 0, "STEP", 0, 0, 'L');
        $pdf->Cell(30, 0, "STAFF NO", 0, 0, 'L');
        $pdf->Cell(60, 0, "CADRE", 0, 1, 'L');

        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(35, 0, $data['gl'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(25, 0, $data['step'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(30, 0, $data['service_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(60, 0, $data['cadre'], 0, 1, 0, 0, '', '', true);


        $pdf->Ln();
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(45, 0, "APPOINTMENT TYPE ", 0, 0, 'L');
        $pdf->Cell(80, 0, "MDA/INSTITUTION", 0, 0, 'L'); //: : 
        $pdf->Cell(60, 0, "DEPARTMENT", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(44, 0, $data['appointment_type'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(80, 0, $data['mda'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(60, 0, $data['department'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln(13);

        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(0, 0, 'BANK DETAILS', 'TB', 1, 'C');
        $pdf->Ln(2);
        $pdf->SetFont('times', 'B', 11);
        $pdf->Cell(70, 0, "NAME OF BANK", 0, 0, 'L');
        $pdf->Cell(70, 0, "ACCOUNT NUMBER", 0, 0, 'L'); //: : 
        $pdf->Cell(70, 0, "BVN", 0, 1, 'L');
        $pdf->SetFont('times', '', 11);
        $pdf->MultiCell(70, 0, $data['bank_name'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['account_no'], 0, 1, 0, 0, '', '', true);
        $pdf->MultiCell(70, 0, $data['bvn'], 0, 1, 0, 0, '', '', true);
        $pdf->Ln();
        if ($data['appointment_type'] === 'CAREER') {
            $pdf->SetFont('times', 'B', 11);
            $pdf->Cell(70, 0, "PFA NAME", 0, 0, 'L');
            $pdf->Cell(70, 0, "PFA PIN", 0, 1, 'L'); //: : 
            $pdf->SetFont('times', '', 11);
            $pdf->MultiCell(70, 0, $data['pfa_name'], 0, 1, 0, 0, '', '', true);
            $pdf->MultiCell(70, 0, $data['pfa_pin'], 0, 1, 0, 0, '', '', true);
        }
        // $txt = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';        
        // $pdf->MultiCell(55, 5, $txt, 0, 1, 0, 0, '', '', true);
//$pdf->writeHTML('<h5 style="border-top:1px;width:50px">Sign,Date & Name of Employee</h5>', true, false, false, false, ''); 
//$pdf->writeHTMLCell(60, 0, '', '', '<h5 style="border-top:1px">Sign,Date & Name of Employee</h5>', 0, 0);
//$pdf->writeHTMLCell(50, 0, '', '', '<h5>Sign,Date & Name of Employee</h5>', 'T', 0);
        $pdf->Ln(17);
        $pdf->SetFont('', 'B', 12);
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of Employee', 'T', 'L', 0, 0, '', '', true);
        $pdf->SetFont('', 'B', 12);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date&Name of Enrolment Officer', 'T', 0, 0, 0, '', '', true);
        $pdf->Cell(5, 0, '', 0, 0, 'L');
        $pdf->MultiCell(60, 0, 'Sign,Date & Name of OAGF Team Leader.', 'T', 'L', 0, 0, '', '', true);

        //Clear buffer
        ob_end_clean();
// DREAW LINE
        //  
// ---------------------------------------------------------
//Close and display output PDF document onbrwser

        $pdf->Output('Employee Certificate.pdf', 'I');
    }

}
