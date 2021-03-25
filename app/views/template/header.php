<?php
$id= functions::get_id();
$data = functions::get_company_setting();
$name = ucwords(strtolower($data['comp_name']));
?>

<html>
    <head>
       <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta http-equiv="cache-control" content="no-cache" />
            <meta http-equiv="pragma" content="no-cache" />

        <link rel="stylesheet" href="<?= asset; ?>css/app_style.css">
        <link rel="stylesheet" href="<?= asset; ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?= asset; ?>css/mdb.css"> 

        <link rel="stylesheet" href="<?= asset; ?>css/main_style.css">
        
        <link rel="stylesheet" href="<?= asset; ?>css/material-icons.css">   
       
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
                <p id="info" class="pull-right ">Welcome,<strong class="user_fullname" style="font-size:13px;font-weight: bold"><?= functions::get_username()?></strong>.
<!--                    | <a href="/admin/dashboard" class="myrole hidden">Admin Panel</a>-->
                    | <a href="profile">Profile</a>
                    | <a href="logout?q=<?= $id ?>"><i class="fa fa-sign-out-alt"></i>Log Out</a>
                </p>
                <a href="#" class="main_color" id="logo">
                    <img src="<?= base_url . $data['logo']; ?>" alt="Logo" width="100px" height="50px">
                    <strong style="font-size:1.8em;font-weight: bold" class="main_color">CMO (Service Wide Posting)</strong>
<!--                    <span class="main_color valign-helper">Integrated Personnel and Payroll Information System Capturing</span>-->
                </a>

            </div>


            <div id="pjax-container" class="">
                <ul id="nav" class="">
                   <li class="inactive ">
                        <a class="dashboard_page  " href="/pstng/dashboard?q=<?= $id ?>" ><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>  

                    </li>

                    <li class="inactive">
                        <a class=" nominal_roll_page " href="/pstng/nominal_roll?q=<?= $id ?>" ><i class="fa fa-user-alt"></i> Nominal roll</a>                         
                    </li>

                    <li class="inactive">
                        <a class="posting_page " href="/pstng/pst?q=<?= $id ?>" ><i class="fas fa-receipt"></i> Posting </a>  
                    </li>
                    
                    <li class="inactive">
                        <a class="proposal_page " href="/pstng/proposal?q=<?= $id ?>" ><i class="fas fa-edit"></i> Posting Proposal</a>  
                    </li>
                    
                     <li class="inactive">
                        <a class="report_page " href="/pstng/report?q=<?= $id ?>" ><i class="fas fa-book-open"></i> Report </a>  

                    </li>
                    <li class="inactive">
                        <a class="upload_page " href="/pstng/upload?q=<?= $id ?>" ><i class="fas fa-cloud-upload-alt"></i> Upload </a>  

                    </li>
                    
                    
                </ul>


                </nav>
                <div id="content">



                    <input type="hidden" id="type_enroll"/>





