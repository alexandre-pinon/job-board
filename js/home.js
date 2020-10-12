$(document).ready(function () {

    /** GLOBAL VARS **/
    var onModalClose = "";

    /** FUNCTIONS **/

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
                <div class="row container">
                    <div class="card hoverable grey darken-3 white-text">
                        <div class="card-image">
                            <img src="../ressources/company_backgrounds/` + background + `" class="job-image">
                            <a class="activator btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
                            <a class="btn-floating halfway-fab company-logo"><img src="../ressources/company_logos/` + logo + `"></a>
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

        // Submit form event listener
        $('.submit-trigger').click(function () {
            var advertisement_id = $(this).attr('id');
    
            $('.submit-btn').click(function (e) {
                e.preventDefault();

                // Retrieve input values
                var fname = $('#fname').val();
                var lname = $('#lname').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var message = $('#message').val();
                var cv = $('#cv').val();

                // Ajax POST to API to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "http://job-board/api/job_applications.php",
                    data: {
                        "fname": fname,
                        "lname": lname,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "cv": cv,
                        "advertisement_id": advertisement_id,
                        "callType": "apply"
                    },
                    success: function (data) {
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

            // Ajax POST to filter and insert input into database
            $.ajax({
                type: "POST",
                url: "http://job-board/api/users.php",
                data: {
                    "fname": fname,
                    "lname": lname,
                    "password": password,
                    "confirmPassword": confirmPassword,
                    "email": email,
                    "phone": phone,
                    "cv": cv,
                    "callType": "register"
                },
                success: function (data) {

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
                        $('#register_modal').modal("close");
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
                url: "../php/crud/read_users.php",
                data: {
                    "email": email,
                    "password": password,
                },
                success: function (data) {

                    // Display error messages to user
                    $('#register_nameErr').html(data.nameErr);
                    $('#register_passwordErr').html(data.passwordErr);
                    $('#register_confirm_passwordErr').html(data.confirmPasswordErr);
                    $('#register_emailErr').html(data.emailErr);
                    $('#register_phoneErr').html(data.phoneErr);
                    $('#register_cvErr').html(data.cvErr);
                    $('#register_form')[0].reset();

                    if (data.register_success) {
                        // Close form and define alert message
                        onModalClose = data.register_message;
                        $('#register_modal').modal("close");
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
    }

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

    // Charge Materialize components
    $('.modal').modal();
    $('textarea#message').characterCounter();
    $('.sidenav').sidenav();
});