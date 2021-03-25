<?php
$com = new common();
$data = $com->get_company_setting();
$name = ucwords(strtolower($data['comp_name']));
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" href="<?= asset; ?>css/app_style.css">
        <link rel="stylesheet" href="<?= asset; ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?= asset; ?>css/mdb.css"> 

        <link rel="stylesheet" href="<?= asset; ?>css/main_style.css">
       
        <link rel="stylesheet" href="<?= asset; ?>css/material-icons.css">   
        <link rel="stylesheet" href="<?= asset; ?>css/dataTables.bootstrap.css"> 
        <link rel="stylesheet" href="<?= asset; ?>css/admin.css">
        <link rel="stylesheet" href="<?= asset; ?>css/jquery.dataTables.min.css">

        <link rel="stylesheet" href="<?= asset; ?>css/toastr.min.css">
        <link rel="stylesheet" href="<?= asset; ?>css/all.css">
        <link rel="stylesheet" href="<?= asset; ?>css/jquery.datetimepicker.css">
        <link rel="stylesheet" href="<?= asset; ?>css/dropdown.css">

        <link rel="stylesheet" href="<?= asset; ?>css/reg.cssb">
        <link href="<?= asset ?>css/smart_wizard.css" rel="stylesheet" type="text/css" />
        <link href="<?= asset; ?>css/smart_wizard_theme_dots.min.css" rel="stylesheet" type="text/css" />  

        <link  href="<?= asset; ?>images/favicon.png" rel="icon" type="image/png"/>
        <script type="text/javascript" src="<?= asset; ?>js/webcam.min.js"></script>
    </head>
    <style>
        .header_title,.sub_title,.main_color,.top-heading p,.sign-color{color:<?= $data['comp_color']; ?>;}
        .small-box,.btn-custom{background:<?= $data['comp_color']; ?>}
        .top-heading p{color:<?= $data['comp_color']; ?>; border-bottom: 5px solid <?= $data['comp_color']; ?>;}

    </style>
    <body>
        <div class="container">
            <div id="header">
                <p id="info" class="pull-right ">Welcome,<strong class="user_fullname " style="font-size:13px;font-weight: bold"></strong>.
                    | <a href="/ippis_enroll/dashboard" >Enrolment</a>
                    | <a href="/ippis_enroll/logout"><i class="fa fa-sign-out-alt"></i>Log Out</a>
                </p>

                <a href="#" class="main_color" id="logo">
                    <img src="<?= base_url . $data['logo']; ?>" alt="Logo" width="100px" height="50px">
                    <strong style="font-size:1.8em;font-weight: bold" class="main_color"><?= $name ?></strong>
                    <span class="main_color valign-helper">Integrated Personnel and Payroll Information System Capturing</span>
                </a>
            </div>


            <div id="pjax-container" class="">
                <ul id="nav" class="">
                    <li class="inactive ">
                        <a href="dashboard" class="dashboard_page "> <i class="fa fa-tachometer-alt" ></i> Dashboard</a>
                    </li>

                    <li class="inactive ">
                        <a href="nominal_roll" class="nominal_page"><i class="fas fa-user-cog"></i> Nominal Roll</a>
                    </li>

                    <li class="inactive ">
                        <a href="user" class="user_page"><i class="fas fa-user-friends"></i> User</a>
                    </li>

                    <li class="inactive ">
                        <a href="record" class="record_page"><i class="fas fa-receipt"></i> Record</a>
                    </li>
                    <li class="inactive ">
                        <a href="report" class="report_page"><i class="fas fa-registered"></i> Report</a>
                    </li>

                    <li class="inactive ">
                        <a href="setting"class="setting_page" ><i class="fas fa-toolbox"></i>Setting</a>
                    </li>

                    <li class="inactive ">
                        <a href="upload" class="upload_page"><i class="fa fa-cloud-upload-alt"></i> Upload</a>
                    </li>

                    <li class="inactive ">
                        <a href="download" class="download_page"><i class="fas fa-cloud-download-alt"></i> Download</a>
                    </li>

                </ul>


                </nav>
                <div id="content">



                    <input type="hidden" id="type_enroll"/>





