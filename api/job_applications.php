<?php
	// Connect to database
	include("db_connect.php");
	include("filters.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getJobs() {
		global $conn;
		$query = "SELECT * FROM job_application";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)) {
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getJob($id = 0) {
		global $conn;
		$query = "SELECT * FROM job_application";
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
	
	function createJob() {
        global $conn;
		$user_id = $_POST["user_id"];
		$advertisement_id = $_POST["advertisement_id"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
        $cv = $_POST["cv"];
        $message = $_POST["message"];
        
		$query = "INSERT INTO job_application(
            user_id,
            advertisement_id,
            name,
            email,
            phone,
            cv,
            message
        )
        VALUES(
            '".$user_id."',
            '".$advertisement_id."',
            '".$name."',
            '".$email."',
            '".$phone."',
            '".$cv."',
            '".$message."'
        )";
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'Job created successfully.'
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
	
	function updateJob($id) {
		global $conn;
		$_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        
		$user_id = $_PUT["user_id"];
		$advertisement_id = $_PUT["advertisement_id"];
		$name = $_PUT["name"];
		$email = $_PUT["email"];
		$phone = $_PUT["phone"];
        $cv = $_PUT["cv"];
        $message = $_PUT["message"];
        
		$query="UPDATE job_application SET
        user_id='".$user_id."',
        advertisement_id='".$advertisement_id."',
        name='".$name."',
        email='".$email."',
        phone='".$phone."',
        cv='".$cv."',
        message='".$message."'
        WHERE id=".$id;
		
		if(mysqli_query($conn, $query))	{
			$response=array(
				'status' => 1,
				'status_message' =>'Job updated successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error updating job. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteJob($id) {
		global $conn;
		$query = "DELETE FROM job_application WHERE id=".$id;
		if(mysqli_query($conn, $query))	{
			$response=array(
				'status' => 1,
				'status_message' =>'Job deleted successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error deleting job. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function apply() {
		// Define variables and initialize with empty values
		$nameErr = $emailErr = $phoneErr = $messageErr = $cvErr = "";
		$name = $email = $phone = $message = $cv = $advertisement_id = "";

		// Processing form data when form is submitted

		// Validate user name
		if (empty($_POST["fname"]) or empty($_POST["lname"])) {
			$nameErr = "Please enter your name.";
		} else {
			$name = filterName($_POST["fname"], $_POST["lname"]);
			if($name == FALSE) {
				$nameErr = "Please enter a valid name.";
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

		// Validate message
		if (empty($_POST["message"])) {
			$messageErr = "Please enter your message.";
		} else {
			$message = filterString($_POST["message"]);
			if ($message == FALSE) {
				$messageErr = "Please enter a valid message.";
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

		// Get Advertisement ID
		$advertisement_id = (int)$_POST["advertisement_id"];
		$user_id = 0; // By default if not logged in

		// Define Response
		$response = array(
			"nameErr"=>$nameErr,
			"emailErr"=>$emailErr,
			"phoneErr"=>$phoneErr,
			"messageErr"=>$messageErr,
			"cvErr"=>$cvErr
		);
		
		// If no input errors
		if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr) && empty($cvErr)) {
			// Connect to API CRUD
			global $conn;
			// Prepare an insert statement
			$sql = "SELECT * FROM job_application
			WHERE email = ?
			AND advertisement_id = ?";

			if($stmt = mysqli_prepare($conn, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "si", $email, $advertisement_id);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)) {
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) > 0) {
						$response["status"] = 1;
						$response["status_message"] = "You've already apply to this job !";
					} else {
						$query = "INSERT INTO job_application(
							user_id,
							advertisement_id,
							name,
							email,
							phone,
							cv,
							message
						)
						VALUES(
							'".$user_id."',
							'".$advertisement_id."',
							'".$name."',
							'".$email."',
							'".$phone."',
							'".$cv."',
							'".$message."'
						)";
						if(mysqli_query($conn, $query)) {
							$response["status"] = 1;
							$response["status_message"] = "Job Application created successfully.";
						} else {
							$response["status"] = 0;
							$response["status_message"] = "Job Application could not be created.";
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
	
	switch($request_method) {
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"])) {
				$id=intval($_GET["id"]);
				getJob($id);
			} else {
				getJobs();
			}
            break;
		
		case 'POST':
			// Ajouter un produit
			if($_POST["callType"] == "apply") {
				apply();
			} else {
				createJob();
			}
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateJob($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteJob($id);
            break;
            
        default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>