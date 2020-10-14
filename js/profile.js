$(document).ready(function () {

    /** GLOBAL VARS **/
    var user_id;
    var user_email;

    // Init profile form
    $.get('http://job-board/api/session.php', function(data, status) {

        if (status == "success") {
            // Set values with user data
            $('#update_profile_fname').val(data[0].name.split(" ")[0]);
            $('#update_profile_lname').val(data[0].name.split(" ")[1]);
            $('#update_profile_email').val(data[0].email);
            $('#update_profile_phone').val(data[0].phone);
            $('#update_profile_cv').val(data[0].cv);
            $('.profile-label').attr("class", "profile-label active");

            // Set user id & email
            user_id = data[0].id;
            user_email = data[0].email;
        } else {
            alert("Erro loadin session info.");
        }
    });

    // Update profile form event listener
    $('.update_profile-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        var fname = $('#update_profile_fname').val();
        var lname = $('#update_profile_lname').val();
        var email = $('#update_profile_email').val();
        var phone = $('#update_profile_phone').val();
        var cv = $('#update_profile_cv').val();

        // Check if user changed email
        var newEmail;
        if (email != user_email) {
            newEmail = true;
        } else {
            newEmail = false;
        }
        // Ajax PUT to filter and insert input into database
        $.ajax({
            type: "PUT",
            url: "http://job-board/api/users.php?id=" + user_id,
            data: {
                "fname": fname,
                "lname": lname,
                "email": email,
                "newEmail": newEmail,
                "phone": phone,
                "cv": cv,
                "callType": "updateProfile"
            },
            success: function (data) {
                // Display error messages to user
                $('#update_profile_nameErr').html(data.nameErr);
                $('#update_profile_passwordErr').html(data.passwordErr);
                $('#update_profile_confirm_passwordErr').html(data.confirmPasswordErr);
                $('#update_profile_emailErr').html(data.emailErr);
                $('#update_profile_phoneErr').html(data.phoneErr);
                $('#update_profile_cvErr').html(data.cvErr);

                alert(data.status_message);
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