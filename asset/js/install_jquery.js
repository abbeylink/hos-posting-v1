var base_url = window.location.protocol + "//" + window.location.host + "/";
//path to asset
// to get current page url
var url = window.location.href;

$(document).ready(function () {


    $('.isnum').keypress(function (e) {
        var ch = String.fromCharCode(e.which);
        if (!(/[0-9]/.test(ch))) {
            e.preventDefault();
        }
    });


    var process = $('#step').val();

    switch (process) {
        case'step1':
            $('#prereq').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: base_url + "install_ajax/check_requirement",
                    dataType: 'text',
                    success: function (data) { //alert(data);
                        if ($.trim(data) === 'error')
                            alert('Minimum requirements not met!');
                        else
                            location.href = data;
                    }
                });

            });

            break;

        case'step2':
            validate();
            $('#install').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: base_url + "install_ajax/execute",
                    data: data,
                    dataType: 'text',
                    beforeSend: function () {
                        $('#overlay, #loading').show();
                    },
                    success: function (data) {
                        $('#overlay, #loading').hide();
                        if ($.trim(data) === 'Successful')
                            $('#modal_install-done').show();
                        else
                            alert(data);

                    }
                });

            });

    }


    $("#overlay").css({
        opacity: 0.3,
        top: 0,
        left: 0,
        width: $(window).width(),
        height: $(window).height()
    });

    $("#loading").css({
        top: ($(window).height() / 3),
        left: ($(window).width() / 2 - 160)
    });
});

/*
 * Check all input for accurate value
 */
function validate() {
    $('#admin_email').blur(function () {
        var val = $(this).val();
        var val2 = $('#system_email').val();
        if (val2 === val) {
            alert('System Email and Admin Email cannot be the same');
            $(this).val('');
            return;
        }

    });

    $('#confirm_pass').blur(function () {
        var cp = $(this).val();
        var p = $('#password').val();
        if (cp !== p) {
            alert('Password not Match!');
            $(this).val('');
            return;
        }

    });

}