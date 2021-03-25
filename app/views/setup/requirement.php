<?= load::view("template/install_template/header"); ?>
<input type="hidden" id="step" value="step1"/>

<?php $install = new installer(); ?>

<div id="sidebar">
    <h3>Need Help?</h3>
    <p>
        If you are looking for a greater level of support, we provide <u>professional installation services</u> and commercial support with guaranteed response times, and access to the core development team. We can also help customize your App or even add new features to the system to meet your unique needs.');?> <a target="_blank" href="http://afaavalon.com/">Learn More!');?></a>
    </p>
</div>
<div id="main">
    <h2>Thank You for Choosing our Application!</h2>
    <div id="intro">
        <p>We are delighted you have chosen our App for your customer support system!</p>
        <p>The installer will guide you every step of the way in the installation process. You're minutes away from your awesome customer support system!</p>
    </div>
    <h2>Prerequisites</h2>
    <p>Before we begin, we'll check your server configuration to make sure you meet the minimum requirements to run the latest version of our Application.</p>
    <h2>Required: <font color="red"></font></h2>
    These items are necessary in order to install and use our App.
    <div class="extension">
        <?php
        $rec = $install->get_rec();

        foreach ($rec as $key => $value) {
            echo' <li class="' . $value . '">' . $key . '</li>';
        }
        ?>

    </div>
    <h2>Recommended:</h2>
    You can use our App without these, but you may not be able to use all features.


    <div class="extension">
        <?php
        $req = $install->get_server_requirement();

        foreach ($req as $key => $value) {
            echo' <li class="' . $value . '">' . $key . '</li>';
        }
        ?>

    </div>
    <div id="bar">
        <form method="post"id="prereq" >
            <input type="hidden" name="s" value="prereq">
            <input class="btn btn-info btn-sm"  type="submit" name="submit" value="Continue &raquo;">
        </form>
    </div>
</div>





<?= load::view("template/install_template/footer"); ?>







