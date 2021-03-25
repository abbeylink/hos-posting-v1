<?= load::view("template/header") ?>
<title>Posting</title>

<input type="hidden" id="page-name" value="posting"/>

<div id="basic_search">
    <div style="min-height:25px;">
        <form  method="POST" id="search_eng">
            <div class="col-sm-12 col-md-4">
                <div class="form-group d-flex mb-0">
                <input type="text" class="form-control form-control-sm posting" id="basic-user-search" size="30" placeholder="Search " autocomplete="off" autocorrect="off" autocapitalize="off">
                <button type="submit" class="btn btn-info btn-sm" id="search"><i class="fa fa-search"></i></button>
                </div>
                <span class="">Search by Full Name, IPPIS Number</span>
            </div>
        </form>
    </div>
</div>


<div class="row ">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <h2 class="pageheader-title text-dark mb-1">Employee Posting Record</h2> 
        <div class="m-3 p_history">
            <button  data-toggle="tooltip" title="New Posting" data-placement="bottom"  class="btn btn-success btn-sm mb-1 float-right"  id="add_new_posting"><i class="fas fa-plus"></i> New Posting</button>
<!--            <button  data-toggle="tooltip" title="Staff Resumed" data-placement="bottom"  class="btn btn-info btn-sm mb-1 float-right"  id="resume"><i class="fas fa-check"></i>Resume</button>-->

            <div id="loaddata"></div>
        </div>

        
        </div>

    </div>
</div>



    <?= load::view("template/footer"); ?>
  