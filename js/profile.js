$(document).ready(function () {

    /** GLOBAL VARS **/
    var user_id;
    var user_email;
    var user_cv = "";

    // Init profile form
    $.get('../api/session.php', function(data, status) {

        if (status == "success") {
            // Set user cv
            user_cv = data[0].cv;

            // Set values with user data
            $('#update_profile_fname').val(data[0].name.split(" ")[0]);
            $('#update_profile_lname').val(data[0].name.split(" ")[1]);
            $('#update_profile_email').val(data[0].email);
            $('#update_profile_phone').val(data[0].phone);
            $('#update_profile_cv').val(user_cv.slice(user_cv.indexOf("_") + 1, user_cv.length));
            $('.profile-label').attr("class", "profile-label active");

            // Set user id & email
            user_id = data[0].id;
            user_email = data[0].email;

            if(user_cv == "") {
                $('#view_cv_trigger').hide();
            } else {
                $('#view_cv_trigger').show();
                $('.view-cv-btn').attr("href", "../ressources/cv/" + user_cv);
            }
        } else {
            alert("Error loading session info.");
        }
    });

    // Register form event listener
    // $('.update-profile-btn').click(function (e) {
    //     e.preventDefault();

    //     // Retrieve input values
    //     var fname = $('#update_profile_fname').val();
    //     var lname = $('#update_profile_lname').val();
    //     var email = $('#update_profile_email').val();
    //     var phone = $('#update_profile_phone').val();
    //     var cv = $('#update_profile_cv').val();
    //     var file_cv = $('#update_file_cv').prop('files')[0];

    //     console.log(file_cv.name);
    //     console.log(file_cv.type);
    //     console.log(file_cv.size);
    //     console.log(file_cv.error);
    //     console.log(file_cv.tmp_name);

    //     // Check if user changed email
    //     var newEmail;
    //     if (email != user_email) {
    //         newEmail = true;
    //     } else {
    //         newEmail = false;
    //     }

    //     // Retrieve input values in a formData
    //     var form_data = new FormData();
    //     form_data.append("fname", fname);
    //     form_data.append("lname", lname);
    //     form_data.append("email", email);
    //     form_data.append("newEmail", newEmail);
    //     form_data.append("phone", phone);
    //     form_data.append("cv", cv);
    //     // form_data.append("file_cv", file_cv);
    //     form_data.append("callType", "updateProfile");
    //     console.log($('#update_profile_form')[0]);

        // $.ajax({
        //     url: '../api/users.php?id=' + user_id, // point to server-side PHP script 
        //     dataType: 'json',  // what to expect back from the PHP script, if anything
        //     cache: false,
        //     contentType: false,
        //     // processData: false,
        //     data: form_data,
        //     type: 'PUT',
        //     success: function (data) {
        //         // Display error messages to user
        //         $('#update_profile_nameErr').html(data.nameErr);
        //         $('#update_profile_passwordErr').html(data.passwordErr);
        //         $('#update_profile_confirm_passwordErr').html(data.confirmPasswordErr);
        //         $('#update_profile_emailErr').html(data.emailErr);
        //         $('#update_profile_phoneErr').html(data.phoneErr);
        //         $('#update_profile_cvErr').html(data.cvErr);

        //         alert(data.status_message);
        //         console.log(data);
        //     },
        //     error: function (data, status, xhr) {
        //         // Debug if error
        //         console.log(data);
        //         console.log(status);
        //         console.log(xhr);
        //     }
        // });
    // });

    // Update profile form event listener
    $('.update-profile-btn').click(function (e) {
        e.preventDefault();

        // If user logged in and field preset, reset cv to correct name
        // before retrieving inputs
        if (user_cv != "") {
            $('#update_profile_cv').val(user_cv);
        }

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

        var file_cv = $('#update_file_cv').prop('files')[0];
        // If there is a file to upload
        if (file_cv != undefined) {
            // Retrieve input values in a formData
            var form_data = new FormData();
            form_data.append("fname", fname);
            form_data.append("lname", lname);
            form_data.append("email", email);
            form_data.append("newEmail", newEmail);
            form_data.append("phone", phone);
            form_data.append("cv", cv);
            form_data.append("file_cv", file_cv);
            form_data.append("callType", "updateProfileUpload");

            $.ajax({
                url: '../api/users.php?id=' + user_id, // point to server-side PHP script 
                dataType: 'json',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    // Display error messages to user
                    $('#update_profile_nameErr').html(data.nameErr);
                    $('#update_profile_passwordErr').html(data.passwordErr);
                    $('#update_profile_confirm_passwordErr').html(data.confirmPasswordErr);
                    $('#update_profile_emailErr').html(data.emailErr);
                    $('#update_profile_phoneErr').html(data.phoneErr);
                    $('#update_profile_cvErr').html(data.cvErr);

                    location.reload();
                    alert(data.status_message);
                },
                error: function (data, status, xhr) {
                    // Debug if error
                    console.log(data);
                    console.log(status);
                    console.log(xhr);
                }
            });
        } else {
            // Ajax PUT to filter and insert input into database
            $.ajax({
                type: "PUT",
                url: "../api/users.php?id=" + user_id,
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

                    location.reload();
                    alert(data.status_message);
                },
                error: function (data, status, xhr) {
                    // Debug if error
                    console.log(data);
                    console.log(status);
                    console.log(xhr);
                }
            });
        }    
    });

    // Reset Password form event listener
    $('.reset-password-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        var oldPassword = $('#old_password').val();
        var newPassword = $('#new_password').val();
        var confirmNewPassword = $('#new_confirm_password').val();

        // Ajax PUT to filter and insert input into database
        $.ajax({
            type: "PUT",
            url: "../api/users.php?id=" + user_id,
            data: {
                "oldPassword": oldPassword,
                "newPassword": newPassword,
                "confirmNewPassword": confirmNewPassword,
                "callType": "resetPassword"
            },
            success: function (data) {
                // Display error messages to user
                $('#old_passwordErr').html(data.oldPasswordErr);
                $('#new_passwordErr').html(data.newPasswordErr);
                $('#new_confirm_passwordErr').html(data.confirmNewPasswordErr);

                $('#reset_password_form')[0].reset();

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

    // Charge Materialize components
    $('.tabs').tabs();
});