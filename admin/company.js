$(document).ready(function() {

    // BUTTON TO READ ALL COMPANIES
    $("#b_read").click(function(e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/includes/companies.php", 
            success: function (data) {
                console.log(data);
                data.forEach(row => {

                    $("#table1").append(
                        '<tr><td>' + row.id + '</td><td>' + row.name + '</td><td>' + row.logo + '</td><td>' + row.background + '</td></tr>')
                    
                });
            }
        });

    
        return false;
    
    });

    // BUTTON TO CREATE A NEW COMPANY
    $("#b1").click(function(e){
        e.preventDefault();

        var name = $('#name_inline').val();
        var logo = $('#logo_inline').val();
        var background = $('#background_inline').val();

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/api/companies.php",
            data: {
                "name": name,
                "logo": logo,
                "background": background
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

    // BUTTON TO UPDATE A COMPANY
    $("#b2").click(function(e){
        e.preventDefault();
        
        var id2 = $('#id_inline2').val();
        var name2 = $('#name_inline2').val();
        var logo2 = $('#logo_inline2').val();
        var background2 = $('#background_inline2').val();
        console.log(id2);
        console.log(name2);
        console.log(logo2);
        console.log(background2);
        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/admin/update_companies.php",
            data: {
                "id": id2,
                "name": name2,
                "logo": logo2,
                "background": background2
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

    // BUTTON TO DELETE A COMPANY
    $("#b3").click(function(e){
        e.preventDefault();
        
        var id3 = $('#id_inline3').val();

        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/delete_company.php",
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