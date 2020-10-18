<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getCompanies() {
		global $conn;
		$query = "SELECT * FROM company";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result)) {
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getCompany($id = 0) {
		global $conn;
		$query = "SELECT * FROM company";
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
	
	function createCompany() {
        global $conn;
		$name = $_POST["comp_name"];
		$logo = $_POST["logo"];
		$background = $_POST["background"];
		
		$response = uploadFileImage("file_logo", "logo");
		if ($response["status"]) {
			$response = uploadFileImage("file_background", "background");
			if ($response["status"]) {
				$query = "INSERT INTO company(
					name,
					logo,
					background
				)
				VALUES(
					'".$name."',
					'".$logo."',
					'".$background."'
				)";
				
				if(mysqli_query($conn, $query)) {
					$response["status"] = 1;
					$response["status_message"] = 'Company created successfully.';
				} else {
					$response["status"] = 0;
					$response["status_message"] = 'Error creating company. '. mysqli_error($conn);
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function updateCompany($id) {
		global $conn;
		$_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        
		$name = $_PUT["name"];
		$logo = $_PUT["logo"];
		$background = $_PUT["background"];
        
		$query="UPDATE company SET
        name='".$name."',
        logo='".$logo."',
        background='".$background."'
        WHERE id=".$id;
		
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'Company updated successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error updating company. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteCompany($id) {
		global $conn;
		$query = "DELETE FROM company WHERE id=".$id;
		if(mysqli_query($conn, $query)) {
			$response=array(
				'status' => 1,
				'status_message' =>'Company deleted successfully.'
			);
		} else {
			$response=array(
				'status' => 0,
				'status_message' =>'Error deleting company. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function updateCompanyUpload($id) {
		global $conn;
        
		$name = $_POST["name"];
		$logo = $_POST["logo"];
		$background = $_POST["background"];

		$response = uploadFileImage("file_logo", "logo");
		if ($response["status"]) {
			$response = uploadFileImage("file_background", "background");
			if ($response["status"]) {
				$query="UPDATE company SET
				name='".$name."',
				logo='".$logo."',
				background='".$background."'
				WHERE id=".$id;
				
				if(mysqli_query($conn, $query)) {
					$response["status"] = 1;
					$response["status_message"] = 'Company updated successfully.';
				} else {
					$response["status"] = 0;
					$response["status_message"] = 'Error updating company. '. mysqli_error($conn);
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function uploadFileImage($fileToUpload, $category) {
		// Upload files if exists
		// Check if file was uploaded without errors
		if(isset($_FILES[$fileToUpload]) && $_FILES[$fileToUpload]["error"] == 0) {
			$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
			$filename = $_FILES[$fileToUpload]["name"];
			$filetype = $_FILES[$fileToUpload]["type"];
			$filesize = $_FILES[$fileToUpload]["size"];
		
			// Verify file extension
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!array_key_exists($ext, $allowed)) {
				$response["status"] = 0;
				$response["status_message"] = "Error: Please select a valid file format.";
				return $response;
			} else {
				// Verify file size - 50MB maximum
				$maxsize = 50 * 1024 * 1024;
				if($filesize > $maxsize) {
					$response["status"] = 0;
					$response["status_message"] = "Error: File size is larger than the allowed limit.";
					return $response;
				} else {
					// Verify MYME type of the file
					if(in_array($filetype, $allowed)) {
						// Upload file
						if(file_exists("upload/" . $filename)) {
							$response["status"] = 0;
							$response["status_message"] = $filename . " is already exists.";
							return $response;
						} else {
							move_uploaded_file($_FILES[$fileToUpload]["tmp_name"], "../ressources/company_". $category ."s/". $filename);
							$response["status"] = 1;
							$response["status_message"] = "Your file was uploaded successfully.";
							return $response;
						}
					} else {
						$response["status"] = 0;
						$response["status_message"] = "Error: There was a problem uploading your file. Please try again.";
						return $response;
					}
				}
			}
		} else {
			$response["status"] = 1;
			$response["status_message"] = "No file to upload !";
			return $response;
		}
	}
	
	switch($request_method) {
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"])) {
				$id=intval($_GET["id"]);
				getCompany($id);
			} else {
				getCompanies();
			}
            break;
		
		case 'POST':
			// Ajouter un produit
			if(isset($_POST["callType"]) && ($_POST["callType"] == "updateCompanyUpload")) {
				$id=intval($_GET["id"]);
				updateCompanyUpload($id);
			} else {
				createCompany();
			}
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateCompany($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteCompany($id);
            break;
            
        default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>