<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getCompanies()
	{
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
	
	function getCompany($id = 0)
	{
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
	
	function createCompany()
	{
        global $conn;
		$name = $_POST["name"];
		$logo = $_POST["logo"];
		$background = $_POST["background"];
        
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
			$response=array(
				'status' => 1,
				'status_message' =>'Company created successfully.'
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
	
	function updateCompany($id)
	{
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
	
	function deleteCompany($id)
	{
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
	
	switch($request_method)
	{
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
			createCompany();
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