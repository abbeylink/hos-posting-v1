/* global toastr, scanner, handleImages, imagesScanned */

var base_url = window.location.protocol + "//" + window.location.host + "/";

// to get current page url
var url = window.location.href;
var getid = url.substring(url.lastIndexOf('id') + 3);
var userid = url.substring(url.lastIndexOf('?') + 1);
var page = $('title').text().toLowerCase();


$(document).ready(function () {



//Auto drop down
    type_ahead($('.posting'), 'posting');
    type_ahead($('.nominal'), 'nominal');
    type_ahead($('.report'), 'report');
    type_ahead($('.mda_name'), 'mda');
    type_ahead($('.proposal'), 'proposal');
    /*
     *---------------------------------------------------------------------------------
     *  EACH PAGE ACTION
     *---------------------------------------------------------------------------------
     */

    switch (page) {

        case'login':
            $('#login_frm').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/check_login',
                    data: data,
                    dataType: "text",
                    beforeSend: function () {
                        $('#submit').html('<i class="fa fa-spinner fa-spin text-white fa-2x" ></i> Please wait....');
                        $('#submit').attr('disabled', true);
                    },
                    success: function (data) {
                        // alert(data);
                        $('#submit').html('<i class="fa fa-sign-in-alt"></i> Sign in');
                        $('#submit').attr('disabled', false);
                        if ($.trim(data) === 'Invalid')
                            warning_alert('Invalid Username or Password');
                        else
                            location.href = data;
                        $('#login_frm').trigger('reset');
                    }
                });


            });

            break;
        case'dashboard':
            load_data("ajax/dashboard_data", $("#data"));

            $(document).on('click', '.get_ref_no', function () {
                var ref_no = $(this).attr('data-id');
                var p_date = $(this).attr('data-id1');
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/ref_data',
                    data: {ref_no: ref_no, p_date: p_date},
                    dataType: "text",
                    beforeSend: function () {
                        $('#ref_no_data').html('<i class="fa fa-spinner fa-spin text-info fa-2x" ></i> Please wait....');
                    },
                    success: function (data) {
                        // alert(data);
                        $('#ref_no_data').empty();
                        $('#ref_no').html('Employee Information with REf Number-' + ref_no);
                        $('#ref_no_data').html(data);

                    }
                });

            });
            break;
        case'nominal roll':
            load_data("ajax/employee_data", $("#loaddata"));
            pagination("ajax/employee_data", $("#loaddata"));
            search_engine("ajax/employee_data", $("#loaddata"));
            break;
            case'proposal':
            load_data("ajax/posting_proposal", $("#loaddata"));
            pagination("ajax/posting_proposal", $("#loaddata"));
            search_engine("ajax/posting_proposal", $("#loaddata"));
            
            $('#delete').click(function(){
                var ippis=$('#basic-user-search').val();
               if (confirm('Are you sure you want to delete Staff with IPPIS NO '+ippis)) {
                   $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/delete_staff',
                    data: {ippis:ippis},
                    dataType: "text",
                    beforeSend: function () {
                        $('#delete').html('<i class="fa fa-spinner fa-spin text-white fa-2x" ></i> Please wait....');
                        $('#delete').attr('disabled', true);
                    },
                    success: function (data) {
                        // alert(data);
                        $('#delete').html('<i class="fa fa-trash-alt"></i> Delete');
                        $('#delete').attr('disabled', false);
                       
                    }
                }); 
                }
            });
            
            break;
            
        case'posting':
            load_data("ajax/employee_posting_data", $("#loaddata"));
            pagination("ajax/employee_posting_data", $("#loaddata"));
            search_engine("ajax/employee_posting_data", $("#loaddata"));

            //New Posting
            $('#add_new_posting').click(function () {
                location.href = '/pstng/process_pstng?' + userid;
            });
            //View Posting History
            $(document).on('click', '.view_history', function () {
                var ippis_no = $(this).attr('data-id');
                location.href = '/pstng/view_pstng?' + userid + "&id=" + ippis_no;

            });

            break;
        case'posting history':

            load_data("ajax/employee_posting_history?ippis_no=" + getid, $("#loaddata"));
            pagination("ajax/employee_posting_history", $("#loaddata"));
            search_engine("ajax/employee_posting_history", $("#loaddata"));
            break;
        case'report':

            load_data("ajax/show_report", $("#loaddata"));
            pagination("ajax/show_report", $("#loaddata"));
            search_engine("ajax/show_report", $("#loaddata"));
            break;


        case'process posting':

            $('#search').click(function (e) {
                var id = $('#basic-user-search').val();
                e.preventDefault();

                if (id === '') {
                    warning_alert('Please Enter value');
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/posting_process_data',
                    data: {id: id},
                    dataType: "html",
                    success: function (data) {
                        var msg = JSON.parse(data);
                        warning_alert(msg.from);
                        $('#emp_data').html(msg.info);
                        $('#emp_history').html(msg.history);
                        $('#emp_from').html(msg.from);
                        $('.posting_frm').removeClass('hidden');

                    }
                });
                get_rank_sgl(id);
            });

            $('.remark').change(function () {
                var val = $(this).val();
                var mda = $('.mda_name').val();
                var sgl = $('.sgl').val();
                var rank = $('.rank').val();

                if (mda === '--Select New Mda--') {
                    warning_alert('Please Select New Mda');
                    return;
                }

                if (val === 'To fill a Vacancy' || val === 'To Understudy' || val === 'To Vice') {
                    $('.show_date').removeClass('hidden');
                } else {
                    $('.show_date').addClass('hidden');
                }

                if (val === 'To Vice' || val === 'To Understudy') {
                    $("#vice_staff").removeClass('hidden');
                    $.ajax({
                        type: "POST",
                        url: base_url + 'ajax/staff_vice',
                        data: {mda: mda, sgl: sgl, rank: rank},
                        dataType: "text",
                        beforeSend: function () {
                            $("#vice_staff").html('<i class="fa fa-spinner fa-spin text-primary fa-2x" ></i> Please wait....');
                            $("#vice_staff").empty();
                            $(".staff_vice_panel").addClass('hidden');
                        },
                        success: function (data) {
                            // alert(data);
                            $('.set_title').text('Employee ' + val);
                            $("#title").html("List of Staff  with the same" + " Rank- " + rank + " and Grade Level- " + sgl).addClass('alert alert-info');
                            $("#vice_staff").html(data);
                            $('#simplemodal_to_vice').show();
                        }
                    });
                }

            });
            //Search staff to vice
            $('#search_to_vice_data').submit(function (e) {
                e.preventDefault();
                var search = $('#search_data').val();
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/lookup_staff_vice',
                    data: {search: search},
                    dataType: "text",
                    beforeSend: function () {
                        $("#vice_staff").html('<i class="fa fa-spinner fa-spin text-primary fa-2x" ></i> Please wait....');
                    },
                    success: function (data) {//alert(data);
                        $("#vice_staff").empty();
                        $("#vice_staff").html(data);
                    }
                });
            });

            //Process Staff to vice/to understand Posting
            $(document).on('click', '.get_data', function () {
                var ippis_no = $(this).attr('data-id');
                var name = $(this).attr('data-id1');
                $('#staff_vice_ippis_no').val(ippis_no);
                $('#staff_vice_name').val(name);
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/staff_to_vice_detail',
                    data: {ippis_no: ippis_no},
                    dataType: "text",
                    success: function (data) {//alert(data);
                        $("#vice_staff").addClass('hidden');
                        $(".staff_vice_panel").removeClass('hidden');
                        $(".staff_vice_data").html(data);
                    }
                });
            });

//manually input Employee name
            $('#getname').click(function () {
                var name = $('#setname').val();
                var ippis = $('#setippis').val();
                $('#staff_vice_ippis_no').val(ippis);
                $('#staff_vice_name').val(name);
                alert('Added');
                $('#setname').val('');
                $('#setippis').val('');
            });


            //Populate Mda,Rank,Sgl
            // load_data_custom('ajax/populate_data', $('.mda_name'), 'mda_name');

//            //Add staff  posting data
            $('#process_posting').submit(function (e) {
                e.preventDefault();
                if ($('.mda_name').val() === '') {
                    warning_alert('Please Enter Mda name');
                    return;
                }
                var date = ($('.date').val() !== "") ? " w.e.f " + $('.date').val() : "";

                var id = $('#staff_vice_ippis_no').val();
                var name = $('#staff_vice_name').val();
                var apnd = " (" + name + ")";
                var rmk = $('.remark');
                if (rmk.val() === 'To Vice') {
                    $('#new_remark').val("To Vice " + apnd + " " + date + " ");
                } else if (rmk.val() === 'To Understudy') {
                    $('#new_remark').val("To Understudy " + apnd + " " + date + " ");
                } else if (rmk.val() === 'To fill a Vacancy') {
                    $('#new_remark').val("To fill a Vacancy  " + date + " ");

                } else {
                    $('#new_remark').val(rmk.val());
                }
                var ippis = $('.get_ippis').attr('data-id');
                var previous_mda = $('.previous_mda').val();
                var data = $(this).serialize() + '&ippis_no=' + ippis + '&previous_mda=' + previous_mda;
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/add_employee_posting',
                    data: data,
                    dataType: "html",
                    success: function (data) { //alert(data);
                        $('#emp_data').empty();
                        $('#emp_history').empty();
                        $('#emp_from').empty();
                        $('.posting_frm').addClass('hidden');
                        success_alert(data);
                    }
                });
                $('.mda_name').val('');
                $('.remark').val('Select Remark');

            });

            //Submit all posting processed
            $('#submit_posting').click(function () {
                if (confirm('Are you sure you have processed all Posting')) {
                    $('#simplemodal_submit_pst').show();
                }
            });

            //Save all processed posting
            $('#submit_posting_frm').submit(function (e) {
                e.preventDefault();

                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: base_url + 'ajax/final_submit_employee_posting',
                    data: data,
                    dataType: "html",
                    success: function (data) {
                        $('input').val('');
                        success_alert(data);
                    }
                });

            });



//Generate Excel file for all posting processed
            $('#generate_posting').click(function () {
                if (confirm('Are you sure you have processed all Posting')) {
                    $.ajax({
                        type: "POST",
                        url: base_url + 'ajax/generate_posting_report',
                        dataType: "html",
                        success: function (data) {
                            if ($.trim(data) === 'no data')
                                warning_alert("No Record Found");
                            else
                                location.href = '/ajax/generate_posting_report';
                        }
                    });

                }
            });
            break;

        case 'upload':
            //Validate file to upload wether the file is excel is not
            $('#excel_file').change(function (e) {
                var filename = e.target.value.split('\\').pop();
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                if (extn === "csv") {//"xls" 
                    if (this.files && this.files[0]) {
                        $('#file_name').text(filename);
                        //$('#upload_staff_excel').trigger('click');
                    }
                } else {
                    $(this).val('');
                    $('#file_name').text('Select Excel file');
                    warning_alert('Only .csv file allowed');
                }
            });

            //Upload Excel File
            $('#excel_form').submit(function (e) {

                e.preventDefault();
                $('.progress').removeClass('hidden');
                var record = $('#record').val();
                if ($('#excel_file').val() === '') {
                    warning_alert('Please Select Excel File to Upload');
                    return;
                }

                var formdata = new FormData(this);
                formdata.append('record', record);
                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                var percent = Math.round((e.loaded / e.total) * 100);
                                $('#progbar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
                            }
                        });
                        return xhr;
                    },
                    type: 'POST',
                    url: base_url + 'ajax/upload_file?' + userid,
                    data: formdata,
                    dataType: 'text',
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#upload').html('<i class="fa fa-spinner fa-spin text-white fa-2x" ></i> Uploading is in Progress....');
                        $('#upload').attr('disabled', true);
                    },
                    success: function (data) {
                        // alert(data);
                        $('#upload').html('Upload');
                        $('#upload').attr('disabled', false);
                        success_alert(data);
                        $('#progbar').text('Completed');
                        $('#excel_file').val('');
                        $('#file_name').text('Select Excle File ');
                    }

                });
            });

            break;
    }

    //to vice/understudy lookup
   // load_data("ajax/show_report", $("#loaddata"));
    pagination("ajax/staff_vice", $("#vice_staff"));
    lookup("ajax/staff_vice", $("#vice_staff"));

    $('.closebtn').click(function () {
        $('#simplemodal_to_vice,#simplemodal_submit_pst').hide();
    });

    //Download report
    $(document).on('click', '.download_rpt', function () {

        var ref_no = $(this).attr('data-id');
        var dates = $(this).attr('data-id1');

        $.ajax({
            type: "POST",
            url: base_url + 'ajax/download_repot_url',
            data: {ref_no: ref_no, dates: dates},
            dataType: "text",
            success: function (data) {//alert(data);
                location.href = data;
            }
        });
    });

    /*
     *---------------------------------------------------------------------------------
     *  Function get Sgl and Rank
     *---------------------------------------------------------------------------------
     */

    function get_rank_sgl(id) {
        //
        $.ajax({
            type: "POST",
            url: base_url + 'ajax/get_sgl_rank',
            data: {id: id},
            dataType: "html",
            success: function (data) { //alert(data);
                var msg = JSON.parse(data);
                $('.sgl').val(msg.sgl);
                $('.rank').val(msg.rank);

            }
        });
    }



    /*
     *---------------------------------------------------------------------------------
     *  INPUT ONLY NUMBER
     *---------------------------------------------------------------------------------
     */
    $('.isnum').keypress(function (e) {
        var ch = String.fromCharCode(e.which);
        if (!(/[0-9]/.test(ch))) {
            e.preventDefault();
        }
    });



});











$(window).on('load', function () {
    var name = $('title').text().toLowerCase();
    var page = ['dashboard', 'user', 'report', 'setting', 'upload', 'posting', 'nominal roll', 'record','proposal'];
    var p = ['dashboard', 'user', 'report', 'setting', 'upload', 'posting', 'nominal_roll', 'record','proposal'];
    for (var i = 0; i < page.length; i++) {
        if (name === page[i]) {
            $('.' + p[i] + '_page').addClass('active');
        }



    }

});

//Load data
function load_data(url, id) {
    $.ajax({
        type: "POST",
        url: base_url + url,
        dataType: "html",
        beforeSend: function () {
            $(id).html('<i class="fa fa-spinner fa-spin text-primary fa-2x" ></i> Please wait....');
        },
        success: function (data) {//alert(data);
            $(id).empty();
            $(id).html(data);
        }
    });
}

//Load data base on input
function load_data_custom(url, id, name) {
    $.ajax({
        type: "POST",
        url: base_url + url,
        data: {name: name},
        dataType: "html",
        success: function (data) {
            $(id).html(data);
        }
    });
}

/**********************************************************
 * Loader and unloader function
 * **************************************************************
 */
function myloader(msg) {
    $('.load_text h2').text(msg);
    $('#simplemodal_loader').show();
}

function remove_loader() {
    $('#simplemodal_loader').hide();
}


function success_alert(msg) {
    $('.msg').html(msg).addClass("alert alert-success");
    $('.msg_show').trigger('click');
}
function warning_alert(msg) {
    $('.msg').html(msg).addClass("alert alert-success").addClass("alert alert-warning");
    $('.msg_show').trigger('click');
}


/*
 * TYPEHEAD FUNCTION 
 */
function type_ahead(id, name) {
    $(id).typeahead({
        source: function (query, result)
        {
            $.ajax({
                url: base_url + 'ajax/typeahead_all',
                method: "POST",
                data: {query: query, name: name},
                dataType: "json",
                success: function (data)
                {
                    result($.map(data, function (item) {
                        return item;
                    }));
                }
            });
        }
    });
}

/*
 *---------------------------------------------------------------------------------
 *   PAGINATION FUNCTION
 *---------------------------------------------------------------------------------
 */
function pagination(url, id) {
//    clearInterval();

    $(document).on("click", ".page", function () {
        $.ajax({
            url: base_url + url,
            type: "GET",
            data: {page: $(this).attr("data-page")},
            beforeSend: function () {
                myloader('Processing..');
            },
            success: function (data) {
                remove_loader();
                $(id).html(data);
            }

        });
    });
}
/*
 *---------------------------------------------------------------------------------
 *   SEARCH ENGINE FUNCTION
 *---------------------------------------------------------------------------------
 */

function search_engine(url, id) {
    $('#search').click(function (e) {
        e.preventDefault();
        var option = 'search';
        var search = $('#basic-user-search').val();
        if (search === "") {
            warning_alert('Please Enter Search value');
            return;
        }
        $.ajax({
            url: base_url + url,
            type: "POST",
            data: {search: search, option: option},
            beforeSend: function () {
                $(id).html('<i class="fa fa-spinner fa-spin text-primary fa-2x" ></i> Please wait....');
            },
            success: function (data) {
                $(id).empty();
                $(id).html(data);
            }


        });
    });
}


function lookup(url, id) {
    $('#search_eng').submit(function (e) {
        e.preventDefault();
        var option = 'search';
        var search = $('#search_data').val();
        if (search === "") {
            warning_alert('Please Enter Search value');
            return;
        }
        $.ajax({
            url: base_url + url,
            type: "POST",
            data: {search: search, option: option},
            beforeSend: function () {
                $(id).html('<i class="fa fa-spinner fa-spin text-primary fa-2x" ></i> Please wait....');
            },
            success: function (data) {
                $(id).empty();
                $(id).html(data);
            }


        });
    });
}

