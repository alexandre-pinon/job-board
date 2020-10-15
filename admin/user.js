$(document).ready(function() {


    // BUTTON TO READ ALL USERS
    $("#b_read2").click(function(e) {
        e.preventDefault();
        console.log('ok');
        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/includes/users.php", 
            success: function (data) {
                console.log(data);
                data.forEach(row => {

                    $("#table2").append(
                        '<tr><td>' + row.id + '</td><td>' + row.name + '</td><td>' + row.email + '</td><td>' + row.phone + '</td><td>' + row.password + '</td><td>' +  row.profile + '</td><td>' + row.cv + '</td></tr>')
                    
                });
            }
            
        });

    
        return false;
    
    });


    // BUTTON TO CREATE A NEW USER
    $("#b1").click(function(e){
        e.preventDefault();

        var name = $('#name_inline').val();
        var email = $('#email_inline').val();
        var phone = $('#phone_inline').val();
        var password = $('#password_inline').val();
        var profile = $('#profile_inline').val();
        var cv = $('#cv_inline').val();
        console.log(name);
        console.log(email);
        console.log(phone);
        console.log(password);
        console.log(profile);
        console.log(cv);

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/api/users.php",
            data: {
                "name": name,
                "email": email,
                "phone": phone,
                "password": password,
                "profile": profile,
                "cv": cv,
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

    // BUTTON TO UPDATE A USER
    $("#b2").click(function(e){
        e.preventDefault();
        
        var id2 = $('#id_inline2').val();
        var name2 = $('#name_inline2').val();
        var email2 = $('#email_inline2').val();
        var phone2 = $('#phone_inline2').val();
        var password2 = $('#password_inline2').val();
        var profile2 = $('#profile_inline2').val();
        var cv2 = $('#cv_inline2').val();

        $.ajax({
            type: "POST",
            url: "http://localhost/apino-keisay/admin/update_users.php",
            data: {
                "id": id2,
                "name": name2,
                "email": email2,
                "phone": phone2,
                "password": password2,
                "profile": profile2,
                "cv": cv2
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


    $("#b3").click(function(e){
        e.preventDefault();
        
        var id3 = $('#id_inline3').val();

        $.ajax({
            type: "GET",
            url: "http://localhost/apino-keisay/admin/delete_user.php",
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