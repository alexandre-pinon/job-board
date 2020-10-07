<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="custom.css" rel="stylesheet"> 
    <title>THE Job Board</title>
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
                    FROM advertisement AS a
                    JOIN company AS c ON c.id = a.company_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
                while($row = $result->fetch_assoc()) { ?>

                    <div class="row container">
                        <div class="card hoverable grey darken-3 white-text">
                            <div class="card-image">
                                <img src="company_backgrounds/<?php echo $row["background"]; ?>" class="job-image">
                                <a class="activator btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
                                <a class="btn-floating halfway-fab company-logo"><img src="company_logos/<?php echo $row["logo"]; ?>"></a>
                            </div>
                            <div class="card-content short-description">
                                <span class="card-title"><?php echo $row["title"]; ?></span>
                                <p class=""><?php echo $row["description"]; ?></p>
                            </div>
                            <div class="card-action center">
                                <a id="<?php echo $row["id"]; ?>" class="modal-trigger" href="#apply_modal">Apply now !</a>
                            </div>
                            <div class="card-reveal grey lighten-3 grey-text text-darken-3">
                                <span class="card-title close-reveal">
                                    <?php echo $row["title"]; ?>
                                    <i class="material-icons right">close</i>
                                </span>
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

        <div id="apply_modal" class="modal grey lighten-3 grey-text text-darken-3">
            <div class="modal-content">
                <a class="modal-close center grey lighten-3 grey-text text-darken-3">
                    <h4>Apply Form<i class="material-icons right">close</i></h4>
                </a>
                <div class="row">
                    <form id="apply_form" class="col s12" action="" method="post">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="fname" type="text" class="" name="fname">
                                <label for="fname">First Name</label>
                                <small id="nameErr" class="red-text"></small>
                            </div>
                            <div class="input-field col s6">
                                <input id="lname" type="text" class="" name="lname">
                                <label for="lname">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input id="email" type="email" class="" name="email">
                                <label for="email">Email</label>
                                <small id="emailErr" class="red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone" type="text" class="" name="phone">
                                <label for="phone">Phone</label>
                                <small id="phoneErr" class="red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">edit</i>
                                <textarea id="message" class="materialize-textarea" data-length="1000" name="message"></textarea>
                                <label for="message">Message</label>
                                <small id="messageErr" class="red-text"></small>
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn yellow">
                                <span>CV</span>
                                <input type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input id="cv" class="file-path " type="text" name="cv">
                                <small id="cvErr" class="red-text"></small>
                            </div>
                        </div>
                        <div class="row center">
                            <button class="btn yellow waves-effect waves-light submit-btn" type="submit">
                                Apply
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.dotdotdot/4.1.0/dotdotdot.js"></script>
        <script src="main.js"></script>
    </body>
</html>