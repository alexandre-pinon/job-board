<?php
	// Connect to database
	// include("db_connect.php");
	header('Content-Type: application/json');

	
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getAdvertisements()
	{
		global $conn;
		$query = "SELECT * FROM advertisement";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getAdvertisement($id = 0)
	{
		global $conn;
		$query = "SELECT * FROM advertisement";
		if($id != 0)
		{
			$query .= " WHERE id=" . $id . " LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function createAdvertisement()
	{
        global $conn;
		$title = $_POST["title"];
		$description = $_POST["description"];
		$contract_type = $_POST["contract_type"];
		$starting_date = $_POST["starting_date"];
		$min_salary = $_POST["min_salary"];
        $max_salary = $_POST["max_salary"];
        $localisation = $_POST["localisation"];
		$study_level = $_POST["study_level"];
		$experience_years = $_POST["experience_years"];
        $company_id = $_POST["company_id"];
        
		$query = "INSERT INTO advertisement(
            title,
            description,
            contract_type,
            starting_date,
            min_salary,
            max_salary,
            localisation,
            study_level,
            experience_years,
            company_id
        )
        VALUES(
            '".$title."',
            '".$description."',
            '".$contract_type."',
            '".$starting_date."',
            '".$min_salary."',
            '".$max_salary."',
            '".$localisation."',
            '".$study_level."',
            '".$experience_years."',
            '".$company_id."'
        )";
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Advertisement created successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERROR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function updateAdvertisement($id)
	{
		global $conn;
		$_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        
		$title = $_PUT["title"];
		$description = $_PUT["description"];
		$contract_type = $_PUT["contract_type"];
		$starting_date = $_PUT["starting_date"];
		$min_salary = $_PUT["min_salary"];
        $max_salary = $_PUT["max_salary"];
        $localisation = $_PUT["localisation"];
		$study_level = $_PUT["study_level"];
		$experience_years = $_PUT["experience_years"];
        $company_id = $_PUT["company_id"];
        
		$query="UPDATE advertisement SET
        title='".$title."',
        description='".$description."',
        contract_type='".$contract_type."',
        starting_date='".$starting_date."',
        min_salary='".$min_salary."',
        max_salary='".$max_salary."',
        localisation='".$localisation."',
        study_level='".$study_level."',
        experience_years='".$experience_years."',
        company_id='".$company_id."'
        WHERE id=".$id;
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Advertisement updated successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Error updating advertisement. '. mysqli_error($conn)
			);
			
		}
		
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteAdvertisement($id)
	{
		global $conn;
		$query = "DELETE FROM advertisement WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Advertisement deleted successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Error deleting advertisement. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	switch($request_method)
	{
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getAdvertisement($id);
			}
			else
			{
				getAdvertisements();
			}
            break;
		
		case 'POST':
			// Ajouter un produit
			createAdvertisement();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateAdvertisement($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteAdvertisement($id);
            break;
            
        default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
?>