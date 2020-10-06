$(document).ready(function(){
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
    $('.submit-btn').click(function (e) {
        e.preventDefault();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var message = $('#message').val();
        var cv = $('#cv').val();
        console.log(fname, lname, email, phone, message, cv);
        $.ajax({
            type: "POST",
            url: "form_submit.php",
            data: {"fname": fname, "lname": lname, "email": email, "phone": phone, "message": message, "cv": cv},
            success: function (data) {
                console.log(data);
                $('#nameErr').html(data.nameErr);
                $('#emailErr').html(data.emailErr);
                $('#phoneErr').html(data.phoneErr);
                $('#messageErr').html(data.messageErr);
                $('#cvErr').html(data.cvErr);
                $('#apply_form')[0].reset();
            }
        });
    });
});