$(document).ready(function () {

    /** GLOBAL VARS **/
    var onModalClose = "";
    var onSideNavClose = "";
    var loggedIn = "";
    var user_cv = "";

    /** FUNCTIONS **/

    function switchBar(loggedIn, profile) {
        if(loggedIn) {
            if(profile === "admin") {
                $('#profile_list').append(
                    "<li><a href='http://job-board/admin.html'>Admin Panel</a></li>"
                );
            }
            $('#login_bar').hide();
            $('#profile_bar').show();
        } else {
            if(profile === "admin") {
                $('#profile_list').children(':last').remove();
            }
            $('#profile_bar').hide();
            $('#login_bar').show();
        }
    }

    function reInitApplyForm(loggedIn) {
        if(loggedIn) {
            // Retrieve user data and insert them in the apply form
            $.get('../api/session.php', function(data, status) {
                if (status == "success") {
                    // Set user cv
                    user_cv = data[0].cv;

                    // Set values with user data
                    $('#fname').val(data[0].name.split(" ")[0]);
                    $('#lname').val(data[0].name.split(" ")[1]);
                    $('#email').val(data[0].email);
                    $('#phone').val(data[0].phone);
                    $('#cv').val(user_cv.slice(user_cv.indexOf("_") + 1, user_cv.length));
                    $('.apply-label').attr("class", "apply-label active");
                    console.log(user_cv);
                } else {
                    alert("Error loading session info.");
                }
            });
        } else {
            // Reinitialize all values
            $('#fname').val("");
            $('#lname').val("");
            $('#email').val("");
            $('#phone').val("");
            $('#cv').val("");
        }
    }

    // Display job cards
    function printJobs(ads, companies) {

        // Init company attributes
        background = "";
        logo = "";

        ads.forEach(ad => {
            // Set attributes to corresponding company background & logo
            companies.forEach(company => {
                if (company.id === ad.company_id) {
                    background = company.background;
                    logo = company.logo;
                }
            });

            // Materialize cards display
            $('article').append(`
                <div class="flex-box">
                    <div class="card hoverable grey darken-3 white-text">
                        <div class="card-image">
                            <img src="http://job-board/ressources/company_backgrounds/` + background + `" class="job-image">
                            <a class="activator btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
                            <a class="btn-floating halfway-fab company-logo"><img src="http://job-board/ressources/company_logos/` + logo + `"></a>
                        </div>
                        <div class="card-content short-description">
                            <span class="card-title">` + ad.title + `</span>
                            <p class="">` + ad.description + `</p>
                        </div>
                        <div class="card-action center">
                            <a id="` + ad.id + `" class="modal-trigger submit-trigger" href="#apply_modal">Apply now !</a>
                        </div>
                        <div class="card-reveal grey lighten-3 grey-text text-darken-3">
                            <span class="card-title close-reveal">
                                ` + ad.title + `
                                <i class="material-icons right">close</i>
                            </span>
                            <p>
                                Type of contract : ` + ad.contract_type + `,
                                Localisation : ` + ad.localisation + `
                            </p>
                            <p>` + ad.description + `</p>
                        </div>
                    </div>
                </div>
            `);
        });
        // Truncate card description
        $('.short-description').dotdotdot({
            height: 165,
            fallbackToLetter: true,
            watch: true,
        });

        // "+"" button animation
        $('a.activator').click(function () {
            $(this).parent().parent().animate(
                {height: '500px'},
                'slow'
            );
        });

        // "X" button animation
        $('.close-reveal').click(function () {
            $(this).parent().parent().animate(
                {height: '291.2px'},
                'slow'
            );
        });

        // Apply modal parameters
        $('.modal').modal({
            dismissible: false,
            onCloseEnd: function() {
                // "Alert when closing form"
                if (onModalClose !== "") {
                    alert(onModalClose);
                }
                onModalClose = "";

                // Remove event listener
                $('.submit-btn').off("click");

                // Set/Reset inputs and input error fields
                $('#nameErr').html("");
                $('#emailErr').html("");
                $('#phoneErr').html("");
                $('#messageErr').html("");
                $('#cvErr').html("");

                $('#register_nameErr').html("");
                $('#register_passwordErr').html("");
                $('#register_confirm_passwordErr').html("");
                $('#register_emailErr').html("");
                $('#register_phoneErr').html("");
                $('#register_cvErr').html("");

                $('#apply_form')[0].reset();
                $('#register_form')[0].reset();
            }
        });

        // Apply sidenav parameters
        $('.sidenav').sidenav({
            onCloseEnd: function() {
                // "Alert when closing form"
                if (onSideNavClose !== "") {
                    alert(onSideNavClose);
                }
                onSideNavClose = "";

                // Set/Reset inputs and input error fields
                $('#login_emailErr').html("");
                $('#login_passwordErr').html("");

                $('#login_form')[0].reset();
            }
        });

        // Apply modal event listener
        $('.submit-trigger').click(function () {
            var advertisement_id = $(this).attr('id');

            // Load user data if logged in
            reInitApplyForm(loggedIn);

            // Submit form event listener
            $('.submit-btn').click(function (e) {
                e.preventDefault();

                // If user logged in and field preset, reset cv to correct name
                // before retrieving inputs
                if (loggedIn && (user_cv != "")) {
                    $('#cv').val(user_cv);
                }

                // Retrieve input values in a formData
                var form_data = new FormData($('#apply_form')[0]);
                form_data.append("callType", "apply");
                form_data.append("advertisement_id", advertisement_id);

                // Check if authenticated user changed email
                // if (loggedIn) {
                //     var newCv;
                //     if ($('#cv').val() != user_cv) {
                //         newCv = true;
                //     } else {
                //         newCv = false;
                //     }
                //     form_data.append("newCv", newCv);
                //     console.log(newCv);
                // }

                $.ajax({
                    url: '../api/job_applications.php', // point to server-side PHP script 
                    dataType: 'json',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {
                        console.log(data);
                        // Display error messages to user
                        $('#nameErr').html(data.nameErr);
                        $('#emailErr').html(data.emailErr);
                        $('#phoneErr').html(data.phoneErr);
                        $('#messageErr').html(data.messageErr);
                        $('#cvErr').html(data.cvErr);
                        $('#apply_form')[0].reset();
    
                        if (data.status) {
                            // Close form and define alert message
                            onModalClose = data.status_message;
                            $('#apply_modal').modal("close");
                        } else {
                            alert(data.status_message);
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
    }

    // Charge Materialize components
    $('.modal').modal();
    $('textarea#message').characterCounter();
    $('.sidenav').sidenav();

    // GET ajax request display job cards
    $.get('http://job-board/api/companies.php', function (companies_data, companies_status) {
        if (companies_status === "success") {
            $.get('http://job-board/api/advertisements.php', function (ads_data, ads_status) {
                if (ads_status === "success") {
                    printJobs(ads_data, companies_data);
                } else {
                    alert("Could not retrieve ads data");
                }
            });
        } else {
            alert("Could not retrieve companies data");
        }
    });

    // Switch between profile bars if user connected or not
    $.post('http://job-board/api/session.php', {callType: "checkIfLoggedIn"}, function (data, status) {
        if (status === "success") {
            switchBar(data.loggedIn, data.profile);
            loggedIn = data.loggedIn;
        }
    });

    // Window scroll fadeout effect
    $(window).scroll(function() {
        // $('#home_screen').css("opacity", 0.5 - $(window).scrollTop() / 1200);
        $('#job_div').css("margin-top", 50 - $(window).scrollTop() / 10 + "vh");
    });

    // Register form event listener
    $('.register-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        var fname = $('#register_fname').val();
        var lname = $('#register_lname').val();
        var password = $('#register_password').val();
        var confirmPassword = $('#register_confirm_password').val();
        var email = $('#register_email').val();
        var phone = $('#register_phone').val();
        var cv = $('#register_cv').val();
        var file_cv = $('#register_file_cv').prop('files')[0]

        // Retrieve input values in a formData
        var form_data = new FormData();
        form_data.append("fname", fname);
        form_data.append("lname", lname);
        form_data.append("password", password);
        form_data.append("confirmPassword", confirmPassword);
        form_data.append("email", email);
        form_data.append("phone", phone);
        form_data.append("cv", cv);
        form_data.append("file_cv", file_cv);
        form_data.append("callType", "register");
        console.log($('#register_form')[0]);

        $.ajax({
            url: '../api/users.php', // point to server-side PHP script 
            dataType: 'json',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                console.log(data);
                // Display error messages to user
                $('#register_nameErr').html(data.nameErr);
                $('#register_passwordErr').html(data.passwordErr);
                $('#register_confirm_passwordErr').html(data.confirmPasswordErr);
                $('#register_emailErr').html(data.emailErr);
                $('#register_phoneErr').html(data.phoneErr);
                $('#register_cvErr').html(data.cvErr);
                $('#register_form')[0].reset();

                if (data.status) {
                    // Close form and define alert message
                    onModalClose = data.status_message;
                    switchBar(data.loggedIn, data.profile);
                    loggedIn = data.loggedIn;
                    $('#register_modal').modal("close");
                } else {
                    alert(data.status_message);
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

    // Login form event listener
    $('.login-btn').click(function (e) {
        e.preventDefault();

        // Retrieve input values
        var email = $('#login_email').val();
        var password = $('#login_password').val();

        // Ajax POST to read users and check if corresponds to input
        $.ajax({
            type: "POST",
            url: "http://job-board/api/users.php",
            data: {
                "email": email,
                "password": password,
                "callType": "login"
            },
            success: function (data) {
                // Display error messages to user
                $('#login_emailErr').html(data.emailErr);
                $('#login_passwordErr').html(data.passwordErr);

                $('#login_form')[0].reset();

                if (data.status) {
                    // Close form and define alert message
                    onSideNavClose = data.status_message;
                    switchBar(data.loggedIn, data.profile);
                    loggedIn = data.loggedIn;
                    $('.sidenav').sidenav("close");
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

    // Logout button event listener
    $('.logout-btn').click(function (e) {
        e.preventDefault();

        $.post('http://job-board/api/session.php', {callType: "logout"}, function (data, status) {
            if (status === "success") {
                switchBar(data.loggedIn, data.profile);
                loggedIn = data.loggedIn;
            }
        });
    });
});