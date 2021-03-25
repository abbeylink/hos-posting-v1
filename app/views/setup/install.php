<?= load::view("template/install_template/header"); ?>
<input type="hidden" id="step" value="step2"/>


<div id="main" class="step2">
    <h1> Basic Installation</h1>
    <p>Please fill out the information below to continue your  installation. All fields are required.</p>
    <font class="error"><strong></strong></font>
    <form  method="post" id="install" autocomplete="off">
        <input type="hidden" name="s" value="install">
        <h4 class="head system">System Settings</h4>
        <span class="subhead">The Company name</span>

        <!--                <div class="col-sm-12 col-md-6 row">
                            <div class="form-group">
                                <input type="tex" class="form-control form-control-sm" id="company_name" placeholder="Company Name" required/>
                            </div>
                            
                        </div> -->

        <div class="row">
            <label>Company Name</label>
            <input type="text" name="company_name" id="company_name" size="45" required>
            <a class="tip" href="#helpdesk_name"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>

        <a class="tip" href="#default_lang"><i class="icon-question-sign help-tip"></i></a>
        <font class="error">&nbsp;</font>

        <h4 class="head database">Database Settings</h4>
        <span class="subhead">Database connection information<font class="error"></font></span>

        <div class="row">
            <label>MySQL Hostname</label>
            <input type="text" name="host" id="host" size="45"  value="localhost" required  style="text-transform: none">
            <a class="tip" href="#db_host"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>MySQL Database</label>
            <input type="text" name="db_name" id="db_name" size="45"  required style="text-transform: none">
            <a class="tip" href="#db_schema"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>MySQL Username </label>
            <input type="text" name="user" id="user" size="45" required style="text-transform: none">
            <a class="tip" href="#db_user"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>MySQL Password</label>
            <input type="password" name="pass"  id="pass"size="45" required>
            <a class="tip" href="#db_password"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>

        <h4 class="head admin">Admin User</h4>
        <span class="subhead">Your primary administrator account - you can add more users later</span>
        <div class="row">
            <label>First Name:</label>
            <input type="text" name="first_name" id="first_name" size="45" required>
            <a class="tip" href="#first_name"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>Last Name:</label>
            <input type="text" name="last_name"  id="last_name"size="45" required>
            <a class="tip" href="#last_name"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>Email Address</label>
            <input type="email" name="admin_email" id="admin_email" size="45" required>
            <a class="tip" href="#email"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>

        <div class="row">
            <label>Username</label>
            <input type="text" class="" name="username" id="username" size="45" autocomplete="off">
           </div>
        <div class="row">
            <label>Password</label>
            <input type="password" name="password" id="password" size="45"  autocomplete="off">
            <a class="tip" href="#password"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <div class="row">
            <label>Retype Password</label>
            <input type="password" id="confirm_pass" size="45" >
            <a class="tip" href="#password2"><i class="icon-question-sign help-tip"></i></a>
            <font class="error"></font>
        </div>
        <br>
        <div id="bar">
            <input class="btn btn-primary btn-sm" type="submit" value="Install Now" >
        </div>

    </form>
</div>  
<div id="overlay"></div>
<div id="loading">
    <h4>Please wait... while we configure your  system!</h4>

</div>  



<div id="modal_install-done" class="mymodal">
    <div style="width: 400px;margin-left: 30%">
        <div class="mymodal_content " >  
            <div class="mymodal_header"><h4 >Installation Completed</h4></div>
            <div class="mymodal_body">

                <h1 style="color:green;">Congratulations!</h1>
                <div id="intro">
                    <p>Your Installation has been Completed Successfully.</p>

                    <p>click below link to go to home page</p>
                    <table border="0" cellspacing="0" cellpadding="5" width="580" id="links">
                        <tr>
                            <td width="50%">
                                <strong>Your URL<Br>
                                    <a href="<?php echo base_url; ?>"><?php echo base_url; ?></a>
                            </td>

                        </tr>
                        <tr>
                            <td width="50%">
                                <strong>Our Site</strong><Br>
                                <a href="http://afaavalon.com">http://afaavalon.com/</a>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="sidebar">
                    <h3>What's Next</h3>
                    <p><b>You can now log in  with the Username and password you created during the installation process..</p>
                </div>
            </div>
        </div>



    </div></div>


<?= load::view("template/install_template/footer"); ?>
          

