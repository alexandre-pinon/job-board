$(document).ready(function() {

    // BUTTON TO READ ALL ADVERTISEMENTS
    $("#b_read").click(function(e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "../api/advertisements.php", 
            success: function (data) {
                console.log(data);
                data.forEach(row => {

                    $("#table1").append(
                        '<tr><td>' + row.id + '</td><td>' + row.title + '</td><td>' + row.description + '</td><td>' + row.contract_type + '</td><td>' + row.starting_date + '</td><td>' +  row.min_salary + '</td><td>' + row.max_salary + '</td><td>' + row.localisation + '</td><td>' + row.study_level + '</td><td>' + row.experience_years + '</td><td>' + row.company_id + '</td></tr>')
                    
                });
            }
        });

    
        return false;
    
    });
    
    // BUTTON TO CREATE NEW ADVERTISEMENT
    $("#b1").click(function(e){
        e.preventDefault();

        var title = $('#title_inline').val();
        var description = $('#description_inline').val();
        var contract_type = $('#contract_type_inline').val();
        var starting_date = $('#starting_date_inline').val();
        var min_salary = $('#min_salary_inline').val();
        var max_salary = $('#max_salary_inline').val();
        var localisation = $('#localisation_inline').val();
        var study_level = $('#study_level_inline').val();
        var experience_years = $('#experience_years_inline').val();
        var company_id = $('#company_id_inline').val();

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

            success: function() {
                alert("Create successfully!");
                console.log("OK");

            },

            error: function() {
                console.log("ERR");
            }


        });
    });

    // BUTTON TO UPDATE AN ADVERTISEMENT
    $("#b2").click(function(e){
        e.preventDefault();
        
        var id2 = $('#id_inline2').val();
        var title2 = $('#title_inline2').val();
        var description2 = $('#description_inline2').val();
        var contract_type2 = $('#contract_type_inline2').val();
        var starting_date2 = $('#starting_date_inline2').val();
        var min_salary2 = $('#min_salary_inline2').val();
        var max_salary2 = $('#max_salary_inline2').val();
        var localisation2 = $('#localisation_inline2').val();
        var study_level2 = $('#study_level_inline2').val();
        var experience_years2 = $('#experience_years_inline2').val();
        var company_id2 = $('#company_id_inline2').val(); 

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/admin/update_advertisements.php",
            data: {
                "id": id2,
                "title": title2,
                "description": description2,
                "contract_type": contract_type2,
                "starting_date": starting_date2,
                "min_salary": min_salary2,
                "max_salary": max_salary2,
                "localisation": localisation2,
                "study_level": study_level2,
                "experience_years": experience_years2,
                "company_id": company_id2
            },

            success: function() {
                alert("Update successfully!");
                console.log("OK");

            },

            error: function() {
                console.log("ERR");
            }


        });
    });

    // BUTTON TO DELETE AN ADVERTISEMENT
    $("#b3").click(function(e){
        e.preventDefault();
        
        var id3 = $('#id_inline3').val();

        $.ajax({
            type: "GET",
            url: "../api/advertisements.php",
            data: {
                "id": id3,
            },

            success: function() {
                alert("Delete successfully!");
                console.log("OK");

            },

            error: function() {
                console.log("ERR");
            }


        });
    });


});