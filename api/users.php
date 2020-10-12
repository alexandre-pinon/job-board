<?php
	// Connect to database
	include("db_connect.php");
	include("filters.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getUsers()
	{
		global $conn;
		$query = "SELECT * FROM user";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)) {
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getUser($id = 0)
	{
		global $conn;
		$query = "SELECT * FROM user";
		if($id != 0) {
			$query .= " WHERE id=" . $id . " LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)) {
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function createUser()
	{
        global $conn;
		$name = $_POST["name"];
		$email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $profile = $_POST["profile"];
        $cv = $_POST["cv"];
        
		$query = "INSERT INTO user(
            name,
            email,
            phone,
            password,
            profile,
            cv
        )
        VALUES(
            '".$name."',
            '".$email."',
            '".$phone."',
            '".$password."',
            '".$profile."',
            '".$cv."'
        )";
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'User created successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'ERROR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function updateUser($id)
	{
		global $conn;
		$_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        
		$name = $_PUT["name"];
		$email = $_PUT["email"];
        $phone = $_PUT["phone"];
        $password = $_PUT["password"];
        $profile = $_PUT["profile"];
        $cv = $_PUT["cv"];
        
		$query="UPDATE user SET
        name='".$name."',
        email='".$email."',
        phone='".$phone."',
        password='".$password."',
        profile='".$profile."',
        cv='".$cv."'
        WHERE id=".$id;
		
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'User updated successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error updating user. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteUser($id)
	{
		global $conn;
		$query = "DELETE FROM user WHERE id=".$id;
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'User deleted successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error deleting user. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function register() {
		// Define variables and initialize with empty values
		$nameErr = $passwordErr = $confirmPasswordErr = $emailErr = $phoneErr = $cvErr = "";
		$name = $password = $confirmPassword = $email = $phone = $cv = "";

		// Processing form data when form is submitted

		// Validate user name
        if (empty($_POST["fname"]) or empty($_POST["lname"])) {
            $nameErr = "Please enter your name.";
        } else {
            $name = filterName($_POST["fname"], $_POST["lname"]);
            if($name == FALSE){
                $nameErr = "Please enter a valid name.";
            }
        }

        // Validate password
        if (empty($_POST["password"])) {
            $passwordErr = "Please enter your password.";     
        } else {
            $password = filterPassword($_POST["password"]);
            if ($password == FALSE) {
                $passwordErr = "Please enter a valid password. (min 6 characters)";
            }
        }

        // Validate confirm password
        if (empty($_POST["confirmPassword"])) {
            $confirmPasswordErr = "Please confirm your password.";     
        } else {
            $confirmPassword = filterConfirmPassword($password, $_POST["confirmPassword"]);
            if ($confirmPassword == FALSE) {
                $confirmPasswordErr = "Password did not match.";
            }
        }

        // Validate email address
        if (empty($_POST["email"])) {
            $emailErr = "Please enter your email address.";     
        } else {
            $email = filterEmail($_POST["email"]);
            if ($email == FALSE) {
                $emailErr = "Please enter a valid email address.";
            }
        }

        // Validate phone number
        if (empty($_POST["phone"])) {
            $phone = NULL;
        } else {
            $phone = filterPhoneNumber($_POST["phone"]);
            if ($phone == FALSE) {
                $phoneErr = "Please enter a valid phone number. (10 numbers)";
            }
        }

        // Validate CV
        if (empty($_POST["cv"])) {
            $cv = NULL;
        } else {
            $cv = filterString($_POST["cv"]);
            if ($cv == FALSE) {
                $cvErr = "Please enter a valid cv.";
            }
		}
		
		// Define profile
		$profile = "applicant"; // By default

        // Define Response
        $response = array(
            "nameErr"=>$nameErr,
            "passwordErr"=>$passwordErr,
            "confirmPasswordErr"=>$confirmPasswordErr,
            "emailErr"=>$emailErr,
            "phoneErr"=>$phoneErr,
            "cvErr"=>$cvErr
        );
		
		// If no input errors
		if (empty($nameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($emailErr) && empty($phoneErr) && empty($cvErr)) {
			// Connect to API CRUD
			global $conn;
			// Prepare an insert statement
			$sql = "SELECT * FROM user WHERE email = ?";

			if($stmt = mysqli_prepare($conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $email);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)) {
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) > 0) {
						$response["status"] = 1;
						$response["status_message"] = "User with same email adress already exists !";
					} else {
						$query = "INSERT INTO user(
							name,
							email,
							phone,
							password,
							profile,
							cv
						)
						VALUES(
							'".$name."',
							'".$email."',
							'".$phone."',
							'".$password."',
							'".$profile."',
							'".$cv."'
						)";
						if(mysqli_query($conn, $query)) {
							$response["status"] = 1;
							$response["status_message"] = "User registered successfully.";
						} else {
							$response["status"] = 0;
							$response["status_message"] = "Error ! Could not register user.";
						}
					}
				} else {
					$response["status"] = 0;
					$response["status_message"] = "ERROR 37";
				}
				// Close statement
				mysqli_stmt_close($stmt);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"])) {
				$id=intval($_GET["id"]);
				getUser($id);
			} else {
				getUsers();
			}
            break;
		
			case 'POST':
				// Ajouter un produit
				if($_POST["callType"] == "register") {
					register();
				} else {
					createUser();
				}
				break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateUser($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteUser($id);
            break;
            
        default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>