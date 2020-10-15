$(document).ready(function() {

    // BUTTON TO READ ALL JOB APPLICATIONS
    $("#b_read").click(function(e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/includes/job_applications.php", 
            success: function (data) {
                console.log(data);
                data.forEach(row => {

                    $("#table1").append(
                        '<tr><td>' + row.id + '</td><td>' + row.user_id + '</td><td>' + row.advertisement_id + '</td><td>' + row.name + '</td><td>' + row.email + '</td><td>' +  row.phone + '</td><td>' + row.cv + '</td><td>' + row.message + '</td></tr>')
                    
                });
            }
        });

    
        return false;
    
    });



    // BUTTON TO CREATE A JOB APPLICATION
    $("#b1").click(function(e){
        e.preventDefault();

        var user_id = $('#user_id_inline').val();
        var advertisement_id = $('#advertisement_id_inline').val();
        var name = $('#name_inline').val();
        var email = $('#email_inline').val();
        var phone = $('#phone_inline').val();
        var cv = $('#cv_inline').val();
        var message = $('#message_inline').val();

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/api/job_applications.php",
            data: {
                "user_id": user_id,
                "advertisement_id": advertisement_id,
                "name": name,
                "email": email,
                "phone": phone,
                "cv": cv,
                "message": message 
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

    // BUTTON TO UPDATE A JOB APPLICATION
    $("#b2").click(function(e){
        e.preventDefault();
        
        var id2 = $('#id_inline2').val();
        var user_id2 = $('#user_id_inline2').val();
        var advertisement_id2 = $('#advertisement_id_inline2').val();
        var name2 = $('#name_inline2').val();
        var email2 = $('#email_inline2').val();
        var phone2 = $('#phone_inline2').val();
        var cv2 = $('#cv_inline2').val();
        var message2 = $('#message_inline2').val();

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/admin/update_job_applications.php",
            data: {
                "id": id2,
                "user_id": user_id2,
                "advertisement_id": advertisement_id2,
                "name": name2,
                "email": email2,
                "phone": phone2,
                "cv": cv2,
                "message": message2
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

    // BUTTON TO DELETE A OB APPLICATION
    $("#b3").click(function(e){
        e.preventDefault();
        
        var id3 = $('#id_inline3').val();

        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/delete_job_application.php",
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