<?= load::view("template/header") ?>
<title>Dashboard</title>
 <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title ">Dashboard</h2>
                        <!--                                <div class=""></div>-->
                    </div>
                </div>
            </div>
            


                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                   
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-35 col-sm-12 ">
                        <div class="card">
                            <div class="card-header"><h5>Latest Posting</h5></div>
                            <div class="card-body">
                                <div id="data"></div>
                            </div>
                        </div>

                    </div>

                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12  ">
                        <div class="card">
                            <div class="card-header ref_data"><h5>Employee Posting information</h5></div>
                            <div class="card-body">
                                <div id="ref_no_data">Employee Information based on Ref Number Selected Display here</div>
                            </div>
                        </div>

                    </div>
                </div>
<!--               <span class="badge badge-pill badge-primary">Printy</span>-->
                
                
            </div>

        </div>
    </div>
</div>


<?= load::view("template/footer"); ?>
  