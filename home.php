<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="custom.css" rel="stylesheet"> 
    <title>Document</title>
</head>
    <body>
        <?php
            $servername = "localhost";
            $username = "admin";
            $password = "admin";
            $dbname = "jobboard";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            mysqli_set_charset($conn, "utf8");

            $sql = "SELECT a.id, title, description, contract_type, localisation, c.logo, c.background
                    FROM advertisement a
                    JOIN company c ON c.id = a.company_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) { ?>

                    <div class="row container">
                        <div class="card hoverable grey darken-3 white-text carousel-item">
                            <div class="card-image">
                                <img src="company_backgrounds/<?php echo $row["background"]; ?>" class="job-image">
                                <img src="company_logos/<?php echo $row["logo"]; ?>" class="logo-image">
                                <a class="activator btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
                            </div>
                            <div class="card-content">
                                <span class="card-title"><?php echo $row["title"]; ?></span>
                                <p class="test"><?php echo $row["description"]; ?></p>
                            </div>
                            <div class="card-reveal grey lighten-3 grey-text text-darken-3">
                                <span class="card-title"><?php echo $row["title"]; ?></span>
                                <p>
                                    Type of contract : <?php echo $row["contract_type"]; ?>,
                                    Localisation : <?php echo $row["localisation"]; ?>
                                </p>
                                <p><?php echo $row["description"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "0 results";
            }
            $conn->close();
        ?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js"></script>
        <script src="main.js"></script>
    </body>
</html>