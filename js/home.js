$(document).ready(function () {

    /** GLOBAL VAR **/
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
                {height: '279.2px'},
                'slow'
            );
        });

        // Apply modal parameters
        $('#apply_modal').modal({
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
                $('#apply_form')[0].reset();
            }
        });

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

                // Ajax POST to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "../php/crud/create_jobapps.php",
                    data: {"fname": fname, "lname": lname, "email": email, "phone": phone, "message": message, "cv": cv, "advertisement_id": advertisement_id},
                    success: function (data, status, xhr) {

                        // Display error messages to user
                        $('#nameErr').html(data.nameErr);
                        $('#emailErr').html(data.emailErr);
                        $('#phoneErr').html(data.phoneErr);
                        $('#messageErr').html(data.messageErr);
                        $('#cvErr').html(data.cvErr);
                        $('#apply_form')[0].reset();
    
                        if (data.apply_success) {
                            // Close form and define alert message
                            onModalClose = data.apply_message;
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
    }

    // GET ajax request display job cards
    $.get('../php/crud/read_companies', function (companies_data, companies_status) {
        if (companies_status === "success") {
            $.get('../php/crud/read_ads', function (ads_data, ads_status) {
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
});