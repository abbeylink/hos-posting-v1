<?= load::view("template/header") ?>
<title>Process Posting</title>


<div id="basic_search">
    <div style="min-height:25px;">
        <form  method="POST" >
            <div class="col-sm-12 col-md-4">
                <div class="form-group d-flex mb-0">
                    <input type="text" class="form-control form-control-sm nominal " id="basic-user-search" size="30" placeholder="Search " autocomplete="off" autocorrect="off" autocapitalize="off">
                    <button type="submit" class="btn btn-info btn-sm" id="search" ><i class="fa fa-search"></i></button>
                </div>
                <span class="">Search by Full Name, IPPIS Number</span>
            </div>
        </form>
    </div>
</div>


<div class="row ">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row p-3">
            <h4 class="pageheader-title text-dark-blue mb-3">Employee Posting Process</h4> 
            <button type="button" class="btn btn-info btn-sm ml-auto" id="submit_posting">Submit Posting</button>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h2 class="line">Employee Information</h2>

                <div id="emp_data"></div>
                <hr>


            </div>
            <div class="col-sm-12 col-md-6">
                <h2 class="line">Employee Last (3) Posting History</h2>

                <div id="emp_history"></div>
                <hr>
            </div>
        </div>
        <div class="row">
            <hr>
            <div class="col-sm-12 col-md-6">
                <h2 class="line">Posting From</h2>

                <div id="emp_from"></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <h2 class="line">Posting To</h2>
                <form method="POST" id="process_posting" class="posting_frm hidden">
                    <input type="hidden"  id="staff_vice_name"/>
                    <input type="hidden" name="ippis_no" id="staff_vice_ippis_no"/>
                    <input type="hidden" name="remark"  id="new_remark"/>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group ">
                            <label for="mda_name" class="form-label">New MDA *</label>
                            <input type="text"  class="form-control mda_name" name="present_mda"  id="mda_name">
<!--                            <select  class="form-control mda_name" name="present_mda"  id="mda_name"></select>-->
                        </div>
                    </div>


                    <div class="row pl-3">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group ">
                                <label for="rank" class="form-label ">Rank *</label>
                                <input type="text" class="form-control  rank" name="rank"  required/>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group ">
                                <label for="rank" class="form-label ">Grade Level *</label>
                                <input type="text"  class="form-control  sgl" name="sgl"  required/>
                            </div>
                        </div>
                    </div>
                    <div class="row pl-3">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group ">
                                <label for="cadre" class="form-label text-dark">Cadre</label>
                                <input type="text" class="form-control  " name="cadre"  />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group ">
                                <label for="department" class="form-label text-dark">Department</label>
                                <input type="text"  class="form-control  " name="department"  />
                            </div>
                        </div>
                    </div>

                    <div class="row pl-3">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group ">
                                <label for="rank" class="form-label ">Remark *</label>
                                <select  class="form-control  remark"   id=""><option>Select Remark</option><option>To fill a Vacancy</option><option>On Request</option><option>To Vice</option><option>To Understudy</option><option>Special Request</option><option>New Appointment</option></select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 show_date hidden">
                            <div class="form-group ">
                                <label for="rank" class="form-label ">Effective Date *</label>
                                <input type="date"  class="form-control  date"  />
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-sm">Add Posting</button>
                    </div>
                </form>


            </div>


        </div>


    </div>
</div>
</div>
</div>


<!--id="search_to_vice_data-->

<div id="simplemodal_to_vice" class="mymodal  ">
    <div class="mymodal_content col-sm-6 col-md-5 ">
        <span class="closebtn"  id="close_">&times;</span>
        <div class="mymodal_header"><h5 class="set_title">Employee To Vice</h5></div>
        <div class="mymodal_body" >
            <div class="col-sm-12 col-md-12 mt-1">
                <div id="basic_search">
                    <div style="min-height:20px;">
                        <form  method="POST" id="search_eng">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group d-flex mb-0">
                                    <input type="text" class="form-control form-control-sm nominal " id="search_data" size="30" placeholder="Search " autocomplete="off" autocorrect="off" autocapitalize="off">
                                    <button type="submit" class="btn btn-info btn-sm" id=""><i class="fa fa-search"></i></button>
                                </div>
                                <span class="">Search by Full Name, IPPIS Number</span>
                            </div>
                        </form>
                    </div>
                </div>

          
                <div class="col-sm-12 col-md-6 ">
                    <div class="form-group ">
                        <label for="rank" class="form-label text-dark">Enter Employee Name *</label>
                        <input type="text"  class="form-control" id="setname" />
                        <span class="text-warning">Enter Employee's name if not found</span>
                    </div>                     
                </div>
                <div class="col-sm-12 col-md-6 hidden">
                    <div class="form-group ">
                        <label for="rank" class="form-label text-dark">Enter Employee IPPIS NO *</label>
                        <input type="text"  class="form-control" id="setippis" />
                  </div>                     
                </div>
                <div class="col-sm-12 col-md-6 ">
                <button type="submit" class="btn btn-info btn-sm" id="getname"><i class="fa fa-check"></i> OK</button>
                </div>
                
                <p id="title"></p>
                <div id="vice_staff"></div>

                <div class="staff_vice_panel hidden">  
                    <h2 class="line">Employee Information</h2>
                    <div class="staff_vice_data"></div> 

                </div>
            </div>
        </div>
    </div>
</div>


<div id="simplemodal_submit_pst" class="mymodal  ">
    <div class="mymodal_content col-sm-6 col-md-3 ">
        <span class="closebtn"  id="close_">&times;</span>
        <div class="mymodal_header"><h5 class="">Submit Posting</h5></div>
        <div class="mymodal_body" >
            <div class="col-sm-12 col-md-12 mt-1">
                <div class="alert alert-info">Please Provide Reference Number and Effective date for Posting</div>          
                <form method="post" id="submit_posting_frm" >
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group ">
                            <label  class=" text-dark">File Ref No *</label>
                            <input type="text" class="form-control" name="ref_no" id="ref_no" required/>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group ">
                            <label  class="form-label ">Effective Date *</label>
                            <input type="date" class="form-control" name="effective_date" id="effective_date" required/>
                        </div>
                    </div> 
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    <button type="button" class="btn btn-info btn-sm" id="generate_posting">Generate Posting</button>


                </form>

            </div>
        </div>
    </div>
</div>

<?= load::view("template/footer"); ?>
  