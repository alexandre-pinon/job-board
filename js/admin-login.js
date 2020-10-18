$(document).ready(function () {
    // End session
    $.post('../api/session.php', {callType: "logout"});

    // Login form event listener
    $('.login-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        var email = $('#login_email').val();
        var password = $('#login_password').val();

        // Ajax POST to read users and check if corresponds to input
        $.ajax({
            type: "POST",
            url: "../api/users.php",
            data: {
                "email": email,
                "password": password,
                "callType": "login"
            },
            success: function (data) {
                console.log(data);
                // Display error messages to user
                $('#login_emailErr').html(data.emailErr);
                $('#login_passwordErr').html(data.passwordErr);

                $('#login_form')[0].reset();

                if (data.status) {
                    if (data.profile === "admin") {
                        location.replace("../admin.html");
                    } else {
                        // End session
                        $.post('../api/session.php', {callType: "logout"}, function (status) {
                        });
                        alert("You do not possess admin rights !");
                    }
                }
            },
            error: function (data, status, xhr) {
                // Debug if error
                console.log(data);
                console.log(status);
                console.log(xhr);
            }
        });
    });
});