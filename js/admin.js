$(document).ready(function () {
    // Check admin
    $.post('../api/session.php', {callType: "checkIfAdmin"}, function (data, status) {
        if (status == "success") {
            // If user not admin
            if (!data.status) {
                location.replace("../admin-login.html");
            }
        }
    });

    // Charge Materialize components
    $('.modal').modal();
    $('textarea#description').characterCounter();
    $('.tabs').tabs();
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        autoClose: true
    });

    function initTables(ads, companies, users, jobs) {
        console.log(ads, companies, users, jobs);
        // Init company name
        var name = "";

        ads.forEach(ad => {
            // Initialize select advertisement values
            $('#advertisement_id').append(`<option value="` + ad.id +`">` + ad.title +`</option>`);
            // Set name to corresponding id
            companies.forEach(company => {
                if (company.id === ad.company_id) {
                    name = company.name;
                }
            });

            // Initialize table values
            $('#advertisement_table tbody').append(`
                <tr>
                    <td>` + ad.id + `</td>
                    <td>` + ad.title + `</td>
                    <td>` + ad.contract_type + `</td>
                    <td>` + ad.localisation + `</td>
                    <td>` + name + `</td>
                    <td>
                        <a href="#advertisement_modal" adID="` + ad.id + `" class="modal-trigger advertisement-view-trigger btn red">View</a>
                        <a href="#advertisement_modal" adID="` + ad.id + `" class="modal-trigger advertisement-update-trigger btn red">Update</a>
                        <a href="#" adID="` + ad.id + `" class="btn red advertisement-delete-trigger">Delete</a>
                    </td>
                </tr>
            `);
        });

        companies.forEach(company => {
            // Initialize select company values
            $('#company_id').append(`<option value="` + company.id +`">` + company.name +`</option>`);
            // Initialize table values
            $('#company_table tbody').append(`
                <tr>
                    <td>` + company.id + `</td>
                    <td>` + company.name + `</td>
                    <td>` + company.logo + `</td>
                    <td>` + company.background + `</td>
                    <td>
                        <a href="#company_modal" companyID="` + company.id + `" class="modal-trigger company-view-trigger btn red">View</a>
                        <a href="#company_modal" companyID="` + company.id + `" class="modal-trigger company-update-trigger btn red">Update</a>
                        <a href="#" companyID="` + company.id + `" class="btn red company-delete-trigger">Delete</a>
                    </td>
                </tr>
            `);
        });

        // Init ad title
        var title = "";
        jobs.forEach(job => {

            // Set name to corresponding id
            ads.forEach(ad => {
                if (ad.id === job.advertisement_id) {
                    title = ad.title;
                }
            });

            // Initialize table values
            $('#job_table tbody').append(`
                <tr>
                    <td>` + job.id + `</td>
                    <td>` + job.name + `</td>
                    <td>` + title + `</td>
                    <td>` + job.email + `</td>
                    <td>` + job.phone + `</td>
                    <td>
                        <a href="#job_modal" jobID="` + job.id + `" class="modal-trigger job-view-trigger btn red">View</a>
                        <a href="#job_modal" jobID="` + job.id + `" class="modal-trigger job-update-trigger btn red">Update</a>
                        <a href="#" jobID="` + job.id + `" class="btn red job-delete-trigger">Delete</a>
                    </td>
                </tr>
            `);
        });

        users.forEach(user => {
            // Initialize select advertisement values
            $('#user_id').append(`<option value="` + user.id +`">` + user.name +`</option>`);

            // Initialize table values
            $('#user_table tbody').append(`
                <tr>
                    <td>` + user.id + `</td>
                    <td>` + user.name + `</td>
                    <td>` + user.email + `</td>
                    <td>` + user.phone + `</td>
                    <td>` + user.profile + `</td>
                    <td>
                        <a href="#user_modal" userID="` + user.id + `" class="modal-trigger user-view-trigger btn red">View</a>
                        <a href="#user_modal" userID="` + user.id + `" class="modal-trigger user-update-trigger btn red">Update</a>
                        <a href="#" userID="` + user.id + `" class="btn red user-delete-trigger">Delete</a>
                    </td>
                </tr>
            `);
        });

        /** -------------------- ADVERTISEMENTS -------------------- **/

        $('.advertisement-view-trigger').click(function(e) {
            e.preventDefault();
            var adID = $(this).attr('adID');
            
            // Disable submit btn
            $('#submit').hide();

            // Set values with user data
            $('#id').val(adID);
            $('#title').val(ads.find(ad => ad.id == adID).title);
            $('#description').val(ads.find(ad => ad.id == adID).description);
            M.textareaAutoResize($('#description'));
            $('#contract_type').val(ads.find(ad => ad.id == adID).contract_type);
            $('#starting_date').val(ads.find(ad => ad.id == adID).starting_date);
            $('#min_salary').val(ads.find(ad => ad.id == adID).min_salary);
            $('#max_salary').val(ads.find(ad => ad.id == adID).max_salary);
            $('#localisation').val(ads.find(ad => ad.id == adID).localisation);
            $('#study_level').val(ads.find(ad => ad.id == adID).study_level);
            $('#experience_years').val(ads.find(ad => ad.id == adID).experience_years);
            $('#company_id').val(ads.find(ad => ad.id == adID).company_id);

            $('.advertisement-label').attr("class", "advertisement-label active");

            // Materialize select
            $('select').formSelect();

            // Disable for read
            $('textarea').prop("readOnly", true);
            $('input').prop("disabled", true);
            $('#starting_date').removeClass("datepicker");
        });

        $('.advertisement-update-trigger').click(function(e) {
            e.preventDefault();
            var adID = $(this).attr('adID');

            // Enable submit btn
            $('#submit').show();

            // (Re)enable for update
            $('textarea').prop("readOnly", false);
            $('input').prop("disabled", false);
            $('#starting_date').addClass("datepicker");
            $('#id').prop("readOnly", true);

            // Set values with user data
            $('#id').val(adID);
            $('#title').val(ads.find(ad => ad.id == adID).title);
            $('#description').val(ads.find(ad => ad.id == adID).description);
            M.textareaAutoResize($('#description'));
            $('#contract_type').val(ads.find(ad => ad.id == adID).contract_type);
            $('#starting_date').val(ads.find(ad => ad.id == adID).starting_date);
            $('#min_salary').val(ads.find(ad => ad.id == adID).min_salary);
            $('#max_salary').val(ads.find(ad => ad.id == adID).max_salary);
            $('#localisation').val(ads.find(ad => ad.id == adID).localisation);
            $('#study_level').val(ads.find(ad => ad.id == adID).study_level);
            $('#experience_years').val(ads.find(ad => ad.id == adID).experience_years);
            $('#company_id').val(ads.find(ad => ad.id == adID).company_id);

            $('.advertisement-label').attr("class", "advertisement-label active");

            // Materialize select
            $('select').formSelect();

            $('.submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values
                var title = $('#title').val();
                var description = $('#description').val();
                var contract_type = $('#contract_type').val();
                var starting_date = $('#starting_date').val();
                var min_salary = $('#min_salary').val();
                var max_salary = $('#max_salary').val();
                var localisation = $('#localisation').val();
                var study_level = $('#study_level').val();
                var experience_years = $('#experience_years').val();
                var company_id = $('#company_id').val();

                // Ajax PUT to filter and insert input into database
                $.ajax({
                    type: "PUT",
                    url: "../api/advertisements.php?id=" + adID,
                    data: {
                        "title": title,
                        "description": description,
                        "contract_type": contract_type,
                        "starting_date": starting_date,
                        "min_salary": min_salary,
                        "max_salary": max_salary,
                        "localisation": localisation,
                        "study_level": study_level,
                        "experience_years": experience_years,
                        "company_id": company_id
                    },
                    success: function (data) {
                        $('#advertisement_modal').modal("close");
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
            });
        });

        $('.advertisement-delete-trigger').click(function(e) {
            e.preventDefault();
            var adID = $(this).attr('adID');
            if(confirm("Are you sure you want to delete advertisement n°" + adID + "?")) {
                // Ajax DELETE to DELETE ad
                $.ajax({
                    type: "DELETE",
                    url: "../api/advertisements.php?id=" + adID,
                    success: function (data) {
                        $('#advertisement_modal').modal("close");
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

        $('#advertisement-create-trigger').click(function(e) {
            e.preventDefault();

            // Enable submit btn
            $('#submit').show();

            // (Re)enable for update
            $('textarea').prop("readOnly", false);
            $('input').prop("disabled", false);
            $('#starting_date').addClass("datepicker");
            $('#id').prop("readOnly", true);

            // Materialize select
            $('select').formSelect();

            $('.submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values
                var title = $('#title').val();
                var description = $('#description').val();
                var contract_type = $('#contract_type').val();
                var starting_date = $('#starting_date').val();
                var min_salary = $('#min_salary').val();
                var max_salary = $('#max_salary').val();
                var localisation = $('#localisation').val();
                var study_level = $('#study_level').val();
                var experience_years = $('#experience_years').val();
                var company_id = $('#company_id').val();

                // Ajax POST to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "../api/advertisements.php",
                    data: {
                        "title": title,
                        "description": description,
                        "contract_type": contract_type,
                        "starting_date": starting_date,
                        "min_salary": min_salary,
                        "max_salary": max_salary,
                        "localisation": localisation,
                        "study_level": study_level,
                        "experience_years": experience_years,
                        "company_id": company_id
                    },
                    success: function (data) {
                        $('#advertisement_modal').modal("close");
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
            });
        });

        /** -------------------- COMPANIES -------------------- **/

        $('.company-view-trigger').click(function(e) {
            e.preventDefault();
            var companyID = $(this).attr('companyID');
            
            // Disable submit btn
            $('#company_submit').hide();

            // Set values with user data
            $('#comp_id').val(companyID);
            $('#comp_name').val(companies.find(company => company.id == companyID).name);
            $('#logo').val(companies.find(company => company.id == companyID).logo);
            $('#background').val(companies.find(company => company.id == companyID).background);

            $('.company-label').attr("class", "company-label active");

            // Disable for read
            $('input').prop("disabled", true);
        });

        $('.company-update-trigger').click(function(e) {
            e.preventDefault();
            var companyID = $(this).attr('companyID');

            // Enable submit btn
            $('#company_submit').show();

            // (Re)enable for update
            $('input').prop("disabled", false);
            $('#comp_id').prop("readOnly", true);

            // Set values with user data
            $('#comp_id').val(companyID);
            $('#comp_name').val(companies.find(company => company.id == companyID).name);
            $('#logo').val(companies.find(company => company.id == companyID).logo);
            $('#background').val(companies.find(company => company.id == companyID).background);

            $('.company-label').attr("class", "company-label active");

            $('.company-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values
                var name = $('#comp_name').val();
                var logo = $('#logo').val();
                var background = $('#background').val();

                var file_logo = $('#file_logo').prop('files')[0];
                var file_background = $('#file_background').prop('files')[0];
                // If there is a file to upload
                if ((file_logo != undefined) || (file_background != undefined)) {
                    // Retrieve input values in a formData
                    var form_data = new FormData();
                    form_data.append("name", name);
                    form_data.append("logo", logo);
                    form_data.append("file_logo", file_logo);
                    form_data.append("background", background);
                    form_data.append("file_background", file_background);
                    form_data.append("callType", "updateCompanyUpload");

                    $.ajax({
                        url: '../api/companies.php?id=' + companyID, // point to server-side PHP script 
                        dataType: 'json',  // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (data) {
                            $('#company_modal').modal("close");
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
                        url: "../api/companies.php?id=" + companyID,
                        data: {
                            "name": name,
                            "logo": logo,
                            "background": background
                        },
                        success: function (data) {
                            $('#company_modal').modal("close");
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
        });

        $('.company-delete-trigger').click(function(e) {
            e.preventDefault();
            var companyID = $(this).attr('companyID');
            if(confirm("Are you sure you want to delete company n°" + companyID + "?")) {
                // Ajax DELETE to DELETE company
                $.ajax({
                    type: "DELETE",
                    url: "../api/companies.php?id=" + companyID,
                    success: function (data) {
                        $('#company_modal').modal("close");
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

        $('#company-create-trigger').click(function(e) {
            e.preventDefault();

            // Enable submit btn
            $('#company_submit').show();

            // (Re)enable for update
            $('input').prop("disabled", false);
            $('#comp_id').prop("readOnly", true);

            $('.company-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values in a formData
                var form_data = new FormData($('#company_form')[0]);

                // Ajax POST to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "../api/companies.php",
                    dataType: 'json',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data) {
                        $('#company_modal').modal("close");
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
            });
        });

        /** -------------------- JOB APPLICATIONS -------------------- **/

        $('.job-view-trigger').click(function(e) {
            e.preventDefault();
            var jobID = $(this).attr('jobID');
            
            // Disable submit btn
            $('#job_submit').hide();

            // Set values with user data
            $('#job_id').val(jobID);
            $('#user_id').val(jobs.find(job => job.id == jobID).user_id);
            $('#advertisement_id').val(jobs.find(job => job.id == jobID).advertisement_id);
            $('#job_name').val(jobs.find(job => job.id == jobID).name);
            $('#job_email').val(jobs.find(job => job.id == jobID).email);
            $('#job_phone').val(jobs.find(job => job.id == jobID).phone);
            $('#cv').val(jobs.find(job => job.id == jobID).cv);
            $('#message').val(jobs.find(job => job.id == jobID).message);
            M.textareaAutoResize($('#message'));

            $('.job-label').attr("class", "job-label active");

            // Materialize select
            $('select').formSelect();

            // Disable for read
            $('textarea').prop("readOnly", true);
            $('input').prop("disabled", true);
        });

        $('.job-update-trigger').click(function(e) {
            e.preventDefault();
            var jobID = $(this).attr('jobID');

            // Enable submit btn
            $('#job_submit').show();

            // (Re)enable for update
            $('textarea').prop("readOnly", false);
            $('input').prop("disabled", false);
            $('#job_id').prop("readOnly", true);

            // Set values with user data
            $('#job_id').val(jobID);
            $('#user_id').val(jobs.find(job => job.id == jobID).user_id);
            $('#advertisement_id').val(jobs.find(job => job.id == jobID).advertisement_id);
            $('#job_name').val(jobs.find(job => job.id == jobID).name);
            $('#job_email').val(jobs.find(job => job.id == jobID).email);
            $('#job_phone').val(jobs.find(job => job.id == jobID).phone);
            $('#cv').val(jobs.find(job => job.id == jobID).cv);
            $('#message').val(jobs.find(job => job.id == jobID).message);
            M.textareaAutoResize($('#message'));

            $('.job-label').attr("class", "job-label active");

            // Materialize select
            $('select').formSelect();

            $('.job-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values
                var user_id = $('#user_id').val();
                var advertisement_id = $('#advertisement_id').val();
                var job_name = $('#job_name').val();
                var job_email = $('#job_email').val();
                var job_phone = $('#job_phone').val();
                var cv = $('#cv').val();
                var message = $('#message').val();

                var file_cv = $('#file_cv').prop('files')[0];
                // If there is a file to upload
                if (file_cv != undefined) {
                    // Retrieve input values in a formData
                    var form_data = new FormData();
                    form_data.append("user_id", user_id);
                    form_data.append("advertisement_id", advertisement_id);
                    form_data.append("name", job_name);
                    form_data.append("email", job_email);
                    form_data.append("phone", job_phone);
                    form_data.append("cv", cv);
                    form_data.append("file_cv", file_cv);
                    form_data.append("message", message);
                    form_data.append("callType", "updateJobUpload");

                    $.ajax({
                        url: '../api/job_applications.php?id=' + jobID, // point to server-side PHP script 
                        dataType: 'json',  // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (data) {
                            $('#job_modal').modal("close");
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
                        url: "../api/job_applications.php?id=" + jobID,
                        data: {
                            "user_id": user_id,
                            "advertisement_id": advertisement_id,
                            "name": job_name,
                            "email": job_email,
                            "phone": job_phone,
                            "cv" : cv,
                            "message": message
                        },
                        success: function (data) {
                            $('#job_modal').modal("close");
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
        });

        $('.job-delete-trigger').click(function(e) {
            e.preventDefault();
            var jobID = $(this).attr('jobID');
            if(confirm("Are you sure you want to delete job application n°" + jobID + "?")) {
                // Ajax DELETE to DELETE company
                $.ajax({
                    type: "DELETE",
                    url: "../api/job_applications.php?id=" + jobID,
                    success: function (data) {
                        $('#job_modal').modal("close");
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

        $('#job-create-trigger').click(function(e) {
            e.preventDefault();

            // Enable submit btn
            $('#job_submit').show();

            // (Re)enable for update
            $('textarea').prop("readOnly", false);
            $('input').prop("disabled", false);
            $('#job_id').prop("readOnly", true);

            // Materialize select
            $('select').formSelect();

            $('.job-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values in a formData
                var form_data = new FormData($('#job_form')[0]);

                // Ajax POST to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "../api/job_applications.php",
                    dataType: 'json',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data) {
                        $('#job_modal').modal("close");
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
            });
        });

        /** -------------------- USERS -------------------- **/

        $('.user-view-trigger').click(function(e) {
            e.preventDefault();
            var userID = $(this).attr('userID');
            
            // Disable submit btn
            $('#user_submit').hide();

            // Set values with user data
            $('#usr_id').val(userID);
            $('#user_name').val(users.find(user => user.id == userID).name);
            $('#user_email').val(users.find(user => user.id == userID).email);
            $('#user_phone').val(users.find(user => user.id == userID).phone);
            $('#password').val(users.find(user => user.id == userID).password);
            $('#profile').val(users.find(user => user.id == userID).profile);
            $('#user_cv').val(users.find(user => user.id == userID).cv);

            $('.user-label').attr("class", "user-label active");

            // Materialize select
            $('select').formSelect();

            // Disable for read
            $('input').prop("disabled", true);
        });

        $('.user-update-trigger').click(function(e) {
            e.preventDefault();
            var userID = $(this).attr('userID');

            // Enable submit btn
            $('#user_submit').show();

            // (Re)enable for update
            $('input').prop("disabled", false);
            $('#usr_id').prop("readOnly", true);

            // Set values with user data
            $('#usr_id').val(userID);
            $('#user_name').val(users.find(user => user.id == userID).name);
            $('#user_email').val(users.find(user => user.id == userID).email);
            $('#user_phone').val(users.find(user => user.id == userID).phone);
            $('#password').val(users.find(user => user.id == userID).password);
            $('#profile').val(users.find(user => user.id == userID).profile);
            $('#user_cv').val(users.find(user => user.id == userID).cv);

            $('.user-label').attr("class", "user-label active");

            // Materialize select
            $('select').formSelect();

            $('.user-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values
                var user_name = $('#user_name').val();
                var user_email = $('#user_email').val();
                var user_phone = $('#user_phone').val();
                var password = $('#password').val();
                var profile = $('#profile').val();
                var user_cv = $('#user_cv').val();

                // Check if admin changed password
                var newPassword;
                if (password != users.find(user => user.id == userID).password) {
                    newPassword = true;
                } else {
                    newPassword = false;
                }

                var file_user_cv = $('#file_user_cv').prop('files')[0];
                // If there is a file to upload
                if (file_user_cv != undefined) {
                    // Retrieve input values in a formData
                    var form_data = new FormData();
                    form_data.append("name", user_name);
                    form_data.append("email", user_email);
                    form_data.append("phone", user_phone);
                    form_data.append("password", password);
                    form_data.append("newPassword", newPassword);
                    form_data.append("profile", profile);
                    form_data.append("cv", user_cv);
                    form_data.append("file_cv", file_user_cv);
                    form_data.append("callType", "updateUserUpload");

                    $.ajax({
                        url: '../api/users.php?id=' + userID, // point to server-side PHP script 
                        dataType: 'json',  // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (data) {
                            $('#user_modal').modal("close");
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
                        url: "../api/users.php?id=" + userID,
                        data: {
                            "name": user_name,
                            "email": user_email,
                            "phone": user_phone,
                            "password": password,
                            "newPassword": newPassword,
                            "profile": profile,
                            "cv" : user_cv,
                        },
                        success: function (data) {
                            $('#user_modal').modal("close");
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
        });

        $('.user-delete-trigger').click(function(e) {
            e.preventDefault();
            var userID = $(this).attr('userID');
            if(confirm("Are you sure you want to delete user n°" + userID + "?")) {
                // Ajax DELETE to DELETE company
                $.ajax({
                    type: "DELETE",
                    url: "../api/users.php?id=" + userID,
                    success: function (data) {
                        $('#user_modal').modal("close");
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

        $('#user-create-trigger').click(function(e) {
            e.preventDefault();

            // Enable submit btn
            $('#user_submit').show();

            // (Re)enable for update
            $('input').prop("disabled", false);
            $('#usr_id').prop("readOnly", true);

            // Materialize select
            $('select').formSelect();

            $('.user-submit-btn').click(function(e) {
                e.preventDefault();

                // Retrieve input values in a formData
                var form_data = new FormData($('#user_form')[0]);

                // Ajax POST to filter and insert input into database
                $.ajax({
                    type: "POST",
                    url: "../api/users.php",
                    dataType: 'json',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data) {
                        $('#user_modal').modal("close");
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
            });
        });
    }

    // GET ajax request to fill advertisement table
    $.get('../api/advertisements.php', function (ads_data, ads_status) {
        if (ads_status === "success") {
            $.get('../api/companies.php', function (companies_data, companies_status) {
                if (companies_status === "success") {
                    $.get('../api/users.php', function (users_data, users_status) {
                        if (users_status === "success") {
                            $.get('../api/job_applications.php', function (jobs_data, jobs_status) {
                                if (jobs_status === "success") {
                                    initTables(ads_data, companies_data, users_data, jobs_data);
                                } else {
                                    alert("Could not retrieve jobs data");
                                }
                            });
                        } else {
                            alert("Could not retrieve users data");
                        }
                    });
                } else {
                    alert("Could not retrieve companies data");
                }
            });
        } else {
            alert("Could not retrieve ads data");
        }
    });

    // Modal parameters
    $('.modal').modal({
        dismissible: false,
        onCloseEnd: function() {
            // Remove event listener to prevent double request
            $('.submit-btn').off("click");
            $('.company-submit-btn').off("click");
            $('.job-submit-btn').off("click");
            $('.user-submit-btn').off("click");

            // Reset forms
            $('#advertisement_form')[0].reset();
            M.textareaAutoResize($('#description'));
            $('#company_form')[0].reset();
            $('#job_form')[0].reset();
            M.textareaAutoResize($('#message'));
            $('#user_form')[0].reset();
        }
    });
});