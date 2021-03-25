var base_url = window.location.protocol + "//" + window.location.host + "/";

$(document).ready(function () {


    $('.step_title').removeClass('hidden');
    // Step show event
    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
        // alert("You are on step " + stepNumber + " now");

        switch (stepNumber) {
            case 1:
                var p = $('#personnel_data').serializeArray();
                for (var i = 0; i < p.length; i++) {
                    if (p[i].name !== 'other_name' && p[i].name !== 'last_promotion_date' && p[i].name !== 'pfa_name' && p[i].name !== 'pfa_pin' &&
                            p[i].name !== 'comment' && p[i].name !== 'reference_id' && p[i].value === '') {
                        warning_alert('Please Enter ' + p[i].name);
                        $('#smartwizard').smartWizard("reset");
                    } else if (p[i].name === 'state_of_resident' && p[i].value === '--Select State--') {
                        warning_alert('Please Enter ' + p[i].name);
                        $('#smartwizard').smartWizard("reset");
                    } else if (p[i].name === 'date_of_birth') {
                        var chk_dob = moment($('#date_of_birth').val(), 'DD/MM/YYYY', true);
                        if (chk_dob.isValid()) {
                        } else {
                            warning_alert('Invalid Date Format.. Please check date of birth');
                            $('#date_of_birth').val('');
                            $('#smartwizard').smartWizard("reset");
                        }

                    } else if (p[i].name === 'phone_no') {
                        var phone = $('#phone_no').val();
                        if (phone.length > 11 || phone.length < 11) {
                            warning_alert('Please Check the Phone Number digit..');
                            $('#phone_no').val('');
                            $('#smartwizard').smartWizard("reset");
                        }
                    } else if (p[i].name === 'date_of_commission') {
                        var chk_d = moment($('#date_of_commission').val(), 'DD/MM/YYYY', true);
                        if (chk_d.isValid()) {
                        } else {
                            warning_alert('Invalid Date Format.. Please check date of birth');
                            $('#date_of_commission').val('');
                            $('#smartwizard').smartWizard("reset");
                        }

                    } else if (p[i].name === 'account_no') {
                        var account = $('#account_no').val();
                        if (account.length > 10 || account.length < 10) {
                            warning_alert('Please Check the Account Number digit..');
                            $('#account_no').val('');
                            $('#smartwizard').smartWizard("reset");
                        }

                    }
                }
                getsummary();
                break;

        }

        if (stepPosition === 'first') {
            $("#prev-btn").addClass('disabled');
        } else if (stepPosition === 'final') {
            $("#next-btn").addClass('disabled');
        } else {
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
        }
    });

    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
            .addClass('btn btn-info')
            .on('click', function () {
                alert('Finish Clicked');
            });
    var btnCancel = $('<button></button>').text('Cancel')
            .addClass('btn btn-danger')
            .on('click', function () {
                $('#smartwizard').smartWizard("reset");
            });


    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'dots',
        transitionEffect: 'fade',
        showStepURLhash: true,
        toolbarSettings: {toolbarPosition: '',
            toolbarButtonPosition: 'end'
                    //  toolbarExtraButtons: [btnFinish, btnCancel]
        }
    });


    // External Button Events
    $("#reset-btn").on("click", function () {
        // Reset wizard
        $('#smartwizard').smartWizard("reset");
        return true;
    });

    $("#prev-btn").on("click", function () {
        // Navigate previous
        $('#smartwizard').smartWizard("prev");
        return true;
    });

    $("#next-btn").on("click", function () {
        // Navigate next
        $('#smartwizard').smartWizard("next");
        return true;
    });

    $("#theme_selector").on("change", function () {
        // Change theme
        $('#smartwizard').smartWizard("theme", $(this).val());
        return true;
    });

    // Set selected theme on page refresh
    //$("#theme_selector").change();
});

function getsummary() {
    var data = $('#personnel_data').serialize();

    $.ajax({
        type: "POST",
        url: base_url + "ajax/show_summary",
        dataType: 'text',
        data: data,
        beforeSend: function () {
//                        myloader('Please wait...');
        },
        success: function (data) {
            //alert(data);
            $("#summary_data").html(data);
        }
    });
    
}


