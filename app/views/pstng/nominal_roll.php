<?= load::view("template/header") ?>
<title>Nominal Roll</title>
<div id="basic_search">
    <div style="min-height:25px;">
        <form  method="POST" id="search_eng">
            <div class="col-sm-12 col-md-4">
                <div class="form-group d-flex mb-0">
                <input type="text" class="form-control form-control-sm nominal" id="basic-user-search" size="30" placeholder="Search " autocomplete="off" autocorrect="off" autocapitalize="off">
                <button type="submit" class="btn btn-info btn-sm" id="search"><i class="fa fa-search"></i></button>
                </div>
                <span class="">Search by Full Name, IPPIS Number</span>
            </div>
        </form>
    </div>
</div>


<div class="row ">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h2 class="pageheader-title text-dark mb-1">Nominal roll</h2>    
    
    
    <div id="loaddata"></div>
</div>
</div>
<?= load::view("template/footer"); ?>
  