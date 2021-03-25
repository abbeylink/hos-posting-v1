<?php
$data = functions::get_company_setting();
$name = ucwords(strtolower($data['comp_name']));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="stylesheet" href="<?= asset; ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?= asset; ?>css/mdb.css">
        <link rel="stylesheet" href="<?= asset; ?>css/login.css">
        <link rel="stylesheet" href="<?= asset; ?>css/main_style.css">

        <link rel="stylesheet" href="<?= asset; ?>css/material-icons.css">   
        <link  href="<?= asset; ?>images/favicon.png" rel="icon" type="image/png"/>
        <title>Login</title>
    </head>



    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">
                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="" class="text-success">
                                            <span><img src="<?= base_url . $data['logo']; ?>" alt="Logo" width="80px" height="50px">  </span>
                                        </a>
                                    </h2>
                                    <!--                                  <h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                                    <form method="POST" id="login_frm">

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input type="text" class="form-control " name="username" id="username" placeholder="Username" required autocomplete="off" style="text-transform: none"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input type="password" class="form-control" name="password"  id="password"value="" placeholder="Password" required/>
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-success btn-sm" id="submit"><i class="fa fa-sign-in-alt"></i> Sign in</button>
                                            </div>
                                        </div>


                                    </form>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- end card-box-->

                            <!-- end wrapper -->

                        </div>
                    </div>
                </div>
        </section>
        <!-- END HOME -->










        <div id="modal_createpassword" class="mymodal">
            <div class="mymodal_content w-25">
                <span class="closebtn"  id="close_crt_pwd">&times;</span>
                <div class="mymodal_header"><h4 >Create Password</h4></div>
                <div class="mymodal_body">

                    <div class="card card-body">
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" name="new_password"  id="new_password"value="" placeholder="Password" required/>
                        </div>

                        <div class="form-group has-feedback text-center">
                            <button type="button" class="btn btn-default" id="create_pwd"><i class="fa fa-registered"></i> Create Password</button>
                        </div>

                    </div>

                </div>

            </div></div>










        <?= load::view("template/footer"); ?>


