$(document).ready(function () {

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