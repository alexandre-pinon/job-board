<?php
	// Connect to database
	include("db_connect.php");
	include("filters.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getUsers() {
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
	
	function getUser($id = 0) {
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
	
	function createUser() {
        global $conn;
		$name = $_POST["name"];
		$email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $profile = $_POST["profile"];
		$cv = $_POST["cv"];
		
		// Password hash
		$password = password_hash($password, PASSWORD_DEFAULT);
        
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
	
	function updateUser($id) {
		global $conn;
		$_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        
		$name = $_PUT["name"];
		$email = $_PUT["email"];
        $phone = $_PUT["phone"];
        $password = $_PUT["password"];
        $profile = $_PUT["profile"];
		$cv = $_PUT["cv"];
		
		// Password hash
		$password = password_hash($password, PASSWORD_DEFAULT);
        
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
	
	function deleteUser($id) {
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

			if($stmt = mysqli_prepare($conn, $sql)) {
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $email);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)) {
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) > 0) {
						$response["status"] = 0;
						$response["status_message"] = "User with same email adress already exists !";
					} else {
						// Password hash
						$password = password_hash($password, PASSWORD_DEFAULT);

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
							// Get created user id and store it in session
							session_start();
							$_SESSION["loggedIn"] = TRUE;
							$_SESSION["id"] = mysqli_insert_id($conn);
							$_SESSION["profile"] = $profile;

							// Define response
							$response["loggedIn"] = $_SESSION["loggedIn"];
							$response["profile"] = $_SESSION["profile"];
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
			// Close connection
			mysqli_close($conn);
		} else {
			$response["status"] = 0;
			$response["status_message"] = "One or more fields are incorrect.";
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function login() {
		// Initialize the session
		session_start();
		// Define response
		$response = array();
		
		// Check if the user is already logged in, if yes then redirect him to welcome page
		if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
			$response["loggedIn"] = $_SESSION["loggedIn"];
			$response["status"] = 1;
			$response["status_message"] = "Already logged in !";
		} else {
			// Define variables and initialize with empty values
			$email = $password = "";
			$emailErr = $passwordErr = "";
			
			// Processing form data when form is submitted
			
			// Check if username is empty
			if(empty(trim($_POST["email"]))) {
				$emailErr = "Please enter email.";
			} else {
				$email = trim($_POST["email"]);
			}
			
			// Check if password is empty
			if(empty(trim($_POST["password"]))) {
				$passwordErr = "Please enter your password.";
			} else {
				$password = trim($_POST["password"]);
			}

			// Define Response
			$response["emailErr"] = $emailErr;
			$response["passwordErr"] = $passwordErr;
			
			// Validate credentials
			if(empty($emailErr) && empty($passwordErr)) {
				
				// Connect to API CRUD
				global $conn;
				// Prepare a select statement
				$sql = "SELECT id, email, password, profile FROM user WHERE email = ?";

				if($stmt = mysqli_prepare($conn, $sql)) {

					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $email);

					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)) {
						// Store result
						mysqli_stmt_store_result($stmt);
						
						// Check if username exists, if yes then verify password
						if(mysqli_stmt_num_rows($stmt) == 1) {                    
							// Bind result variables
							mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $profile);

							if(mysqli_stmt_fetch($stmt)) {
								if(password_verify($password, $hashed_password)) {									
									// Store data in session variables
									$_SESSION["loggedIn"] = TRUE;
									$_SESSION["id"] = $id;
									$_SESSION["profile"] = $profile;

									$response["loggedIn"] = $_SESSION["loggedIn"];
									$response["profile"] = $_SESSION["profile"];
									$response["status"] = 1;
									$response["status_message"] = "Logged in successfully !";
								} else {
									// Display an error message if password is not valid
									$response["status"] = 0;
									$response["passwordErr"] = "The password you entered is not valid.";
								}
							}
						} else {
							// Display an error message if username doesn't exist
							$response["status"] = 0;
							$response["emailErr"] = "No account found with that email.";
						}
					} else {
						$response["status"] = 0;
						$response["status_message"] = "ERROR 37";
					}
					// Close statement
					mysqli_stmt_close($stmt);
				}
				// Close connection
				mysqli_close($conn);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function updateProfile($id, $_PUT) {
		// Define variables and initialize with empty values
		$nameErr = $emailErr = $phoneErr = $cvErr = "";
		$name = $email = $phone = $cv = "";

		// Processing form data when form is submitted

		// Validate user name
        if (empty($_PUT["fname"]) or empty($_PUT["lname"])) {
            $nameErr = "Please enter your name.";
        } else {
            $name = filterName($_PUT["fname"], $_PUT["lname"]);
            if($name == FALSE){
                $nameErr = "Please enter a valid name.";
            }
        }

        // Validate email address
        if (empty($_PUT["email"])) {
            $emailErr = "Please enter your email address.";     
        } else {
            $email = filterEmail($_PUT["email"]);
            if ($email == FALSE) {
                $emailErr = "Please enter a valid email address.";
            }
        }

        // Validate phone number
        if (empty($_PUT["phone"])) {
            $phone = NULL;
        } else {
            $phone = filterPhoneNumber($_PUT["phone"]);
            if ($phone == FALSE) {
                $phoneErr = "Please enter a valid phone number. (10 numbers)";
            }
        }

        // Validate CV
        if (empty($_PUT["cv"])) {
            $cv = NULL;
        } else {
            $cv = filterString($_PUT["cv"]);
            if ($cv == FALSE) {
                $cvErr = "Please enter a valid cv.";
            }
		}

        // Define Response
        $response = array(
            "nameErr"=>$nameErr,
            "emailErr"=>$emailErr,
            "phoneErr"=>$phoneErr,
            "cvErr"=>$cvErr
		);

		// If no input errors
		if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($cvErr)) {
			// Connect to API CRUD
			global $conn;
			if ($_PUT["newEmail"] === "true") {
				// Prepare an insert statement
				$sql = "SELECT * FROM user WHERE email = ?";

				if($stmt = mysqli_prepare($conn, $sql)) {
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $email);
					
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)) {
						/* store result */
						mysqli_stmt_store_result($stmt);
						
						if(mysqli_stmt_num_rows($stmt) > 0) {
							$response["status"] = 0;
							$response["status_message"] = "User with same email adress already exists !";
							header('Content-Type: application/json');
							echo json_encode($response);
							exit();
						}
					} else {
						$response["status"] = 0;
						$response["status_message"] = "ERROR 37";
					}
					// Close statement
					mysqli_stmt_close($stmt);
				}
			}
			$query="UPDATE user SET
				name='".$name."',
				email='".$email."',
				phone='".$phone."',
				cv='".$cv."'
				WHERE id=".$id;
				
			if(mysqli_query($conn, $query)) {
				$response["status"] = 1;
				$response["status_message"] = "User data updated successfully";
			} else {
				$response["status"] = 0;
				$response["status_message"] = "Couldn't update user";
				$response["status_message"] = $id;
			}
			// Close connection
			mysqli_close($conn);
		} else {
			$response["status"] = 0;
			$response["status_message"] = "One or more fields are incorrect.";
		}		
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function resetPassword($id, $_PUT) {
		// Define variables and initialize with empty values
		$oldPasswordErr = $newPasswordErr = $confirmNewPasswordErr = "";
		$oldPassword = $newPassword = $confirmNewPassword = "";

		// Processing form data when form is submitted

		// Check if old password is empty
		if(empty(trim($_PUT["oldPassword"]))) {
			$oldPasswordErr = "Please enter your password.";
		} else {
			$oldPassword = trim($_PUT["oldPassword"]);
		}

        // Validate new password
        if (empty($_PUT["newPassword"])) {
            $newPasswordErr = "Please enter your new password.";     
        } else {
            $newPassword = filterPassword($_PUT["newPassword"]);
            if ($newPassword == FALSE) {
                $newPasswordErr = "Please enter a valid new password. (min 6 characters)";
            } elseif ($newPassword == $oldPassword) {
				$newPasswordErr = "Your new password is the same as the old one ! Please enter a NEEW password.";
			}
        }

        // Validate confirm new password
        if (empty($_PUT["confirmNewPassword"])) {
            $confirmNewPasswordErr = "Please confirm your new password.";     
        } else {
            $confirmNewPassword = filterConfirmPassword($newPassword, $_PUT["confirmNewPassword"]);
            if ($confirmNewPassword == FALSE) {
                $confirmNewPasswordErr = "Password did not match.";
            }
        }

        // Define Response
        $response = array(
            "oldPasswordErr"=>$oldPasswordErr,
            "newPasswordErr"=>$newPasswordErr,
            "confirmNewPasswordErr"=>$confirmNewPasswordErr
		);
		
		// Validate credentials
		if(empty($oldPasswordErr) && empty($newPasswordErr) && empty($confirmNewPasswordErr)) {
				
			// Connect to API CRUD
			global $conn;
			// Prepare a select statement
			$sql = "SELECT password FROM user WHERE id = ?";

			if($stmt = mysqli_prepare($conn, $sql)) {

				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $id);

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)) {
					// Store result
					mysqli_stmt_store_result($stmt);
					
					// Check if user exists, if yes then verify password
					if(mysqli_stmt_num_rows($stmt) == 1) {
						// Bind result variables
						mysqli_stmt_bind_result($stmt, $hashed_password);

						if(mysqli_stmt_fetch($stmt)) {
							if(password_verify($oldPassword, $hashed_password)) {
								// Password hash
								$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
								
								// Update Password
								$query="UPDATE user SET
								password='".$newPassword."'
								WHERE id=".$id;
								
								if(mysqli_query($conn, $query)) {
									$response["status"] = 1;
									$response["status_message"] = "Your password has been successfully reset";
								} else {
									$response["status"] = 0;
									$response["status_message"] = "Couldn't reset password";
								}
							} else {
								// Display an error message if password is not valid
								$response["status"] = 0;
								$response["status_message"] = "Wrong password";
								$response["oldPasswordErr"] = "The password you entered does not correspond yours.";
							}
						}
					} else {
						// Display an error message if user doesn't exist
						$response["status"] = 0;
						$response["status_message"] = "ERROR : No user found with that id";
					}
				} else {
					$response["status"] = 0;
					$response["status_message"] = "ERROR 37";
				}
				// Close statement
				mysqli_stmt_close($stmt);
			}
			// Close connection
			mysqli_close($conn);
		} else {
			$response["status"] = 0;
			$response["status_message"] = "One or more fields is incorrect.";
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method) {
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
			} elseif($_POST["callType"] == "login") {
				login();
			} else {
				createUser();
			}
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			$_PUT = array();
			parse_str(file_get_contents('php://input'), $_PUT);
			if(isset($_PUT["callType"]) && ($_PUT["callType"]== "updateProfile")) {
				updateProfile($id, $_PUT);
			} elseif(isset($_PUT["callType"]) && ($_PUT["callType"]== "resetPassword")) {
				resetPassword($id, $_PUT);
			} else {
				updateUser($id);
			}
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