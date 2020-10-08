$(document).ready(function(){
    var onModalClose = "";
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('.carousel').carousel();
    $('textarea#message').characterCounter();
    $('.short-description').dotdotdot({
        height: 165,
        fallbackToLetter: true,
        watch: true,
    });
    $('a.activator').click(function () {
        $(this).parent().parent().animate(
            {height: '500px'},
            'slow'
        );
    });
    $('.close-reveal').click(function () {
        $(this).parent().parent().animate(
            {height: '279.2px'},
            'slow'
        );
    });
    $('#apply_modal').modal({
        dismissible: false,
        onCloseEnd: function() {
            if (onModalClose !== "") {
                alert(onModalClose);
            }
            onModalClose = "";
        }
    });
    $('.submit-trigger').click(function () {
        var advertisement_id = $(this).attr('id');

        $('.submit-btn').click(function (e) {
            e.preventDefault();
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var message = $('#message').val();
            var cv = $('#cv').val();
            console.log(fname, lname, email, phone, message, cv, advertisement_id);
            $.ajax({
                type: "POST",
                url: "form_submit.php",
                data: {"fname": fname, "lname": lname, "email": email, "phone": phone, "message": message, "cv": cv, "advertisement_id": advertisement_id},
                success: function (data, status, xhr) {
                    $('#nameErr').html(data.nameErr);
                    $('#emailErr').html(data.emailErr);
                    $('#phoneErr').html(data.phoneErr);
                    $('#messageErr').html(data.messageErr);
                    $('#cvErr').html(data.cvErr);
                    $('#apply_form')[0].reset();
                    console.log(data);
                    console.log(status);
                    console.log(xhr);
                    console.log(data.apply_message, data.apply_success);

                    if (data.apply_success) {
                        onModalClose = data.apply_message;
                        $('#apply_modal').modal("close");
                        $('.submit-btn').off("click");

                        // Set/Reset input error fields
                        $('#nameErr').html("");
                        $('#emailErr').html("");
                        $('#phoneErr').html("");
                        $('#messageErr').html("");
                        $('#cvErr').html("");
                    }
                },
                error: function (data, status, xhr) {
                    console.log(data);
                    console.log(status);
                    console.log(xhr);
                    console.log(data.apply_message, data.apply_success);
                }
            });
        });
    });
    $('.modal-close').click(function () {
        $('.submit-btn').off("click");

        // Set/Reset inputs and input error fields
        $('#nameErr').html("");
        $('#emailErr').html("");
        $('#phoneErr').html("");
        $('#messageErr').html("");
        $('#cvErr').html("");
        $('#apply_form')[0].reset();
    });
});