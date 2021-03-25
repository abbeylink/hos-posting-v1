<?= load::view("template/header") ?>
<title>upload</title>

<div class="row">

    <!--Heading-->
    <div class="col-sm-12 col-md-12 col-lg-12 top-heading ">
        <h2>Upload</h2>


        <div class="card card-body">
            <p class="text-danger">Please Ensure to Download Excel File format before Proceed </p>
            <ol>
                <li class="text-dark"> Nominal Roll <a href="/pstng/format_nominal_roll"> Download</a></li>
                 <li class="text-dark"> Posting History <a href="/pstng/format_posting_history"> Download</a></li>
            </ol>
        </div>

        <div class="card card-body">
            <form method="POST" enctype="multipart form-data" id="excel_form">
               
                <div class="col-md-3  select_service ">
                    <label>Select Record</label>
                    <select  class="form-control " name="record"  id="record"><option>Nominal Roll</option><option>Posting History</option></select>
                </div>

                <div class="col-md-3 mt-3">
                    <label for="excel_file" class="file_label bg-default"><i class="fa fa-file-excel fa-lg"></i> <span class="" id="file_name">Select Excel File </span></label> 
                    <input type="file" class="form-control hidden" name="excel_file"  id="excel_file" />
                </div>

                <div class="col-md-3">
                    <button type="submit" class=" btn btn-success btn-sm"   id="upload" ><i class="fa fa-cloud-upload-alt "></i> Upload</button>
                </div>
            </form>

            <div class="progress progress-striped active hidden">
                <div id="progbar" class="progress-bar  progress-bar-primary"  role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
            </div>


        </div>

    </div><!-- End of Row-->

</div> <!-- End of container-->



<?= load::view("template/footer"); ?>
       
