<?php
    class Advertisement {
        // Connection
        private $conn;

        // Table
        private $db_table = "advertisement";

        // Columns
        public $id;
        public $title;
        public $description;
        public $contract_type;
        public $starting_date;
        public $min_salary;
        public $max_salary;
        public $localisation;
        public $study_level;
        public $experience_years;
        public $company_id;

        // Db connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // GET ALL
        public function getAdvertisements() {
            $sqlQuery = "SELECT id, title, description, contract_type, starting_date, min_salary, max_salary, localisation, study_level, experience_years, company_id FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createAdvertisement() {
            $sqlQuery = "INSERT INTO ". $this->db_table ."
            SET
                title = :title,
                contract_type = :contract_type,
                starting_date = :starting_date,
                min_salary = :min_salary,
                max_salary = :max_salary,
                study_level = :study_level,
                experience_years = :experience_years,
                company_id = :company_id";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));    
        $this->contract_type=htmlspecialchars(strip_tags($this->contract_type));
        $this->starting_date=htmlspecialchars(strip_tags($this->statting_date));
        $this->min_salary=htmlspecialchars(strip_tags($this->min_salary));
        $this->max_salary=htmlspecialchars(strip_tags($this->max_salary));
        $this->localisation=htmlspecialchars(strip_tags($this->localisation));
        $this->study_level=htmlspecialchars(strip_tags($this->study_level));
        $this->experience_years=htmlspecialchars(strip_tags($this->experience_years));
        $this->company_id=htmlspecialchars(strip_tags($this->company_id));
        
        // bind data
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":contract_type", $this->description);
        $stmt->bindParam(":starting_date", $this->starting_date);
        $stmt->bindParam(":min_salary", $this->min_salary);
        $stmt->bindParam(":max_salary", $this->max_salary);
        $stmt->bindParam(":study_level", $this->study_level);
        $stmt->bindParam(":experience_years", $this->experience_years);
        $stmt->bindParam(":company_id", $this->company_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
        }

        // READ single
        public function getSingleAdvertisement() {
            $sqlQuery = "SELECT 
                        id, 
                        title, 
                        description, 
                        contract_type, 
                        starting_date, min_salary, 
                        max_salary, localisation, 
                        study_level, 
                        experience_years, 
                        company_id 
                    FROM
                        ". $this->db_table ."
                WHERE
                    id = ?
                LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->title = $dataRow['title'];
            $this->description = $dataRow['description'];
            $this->contract_type = $dataRow['contract_type'];
            $this->starting_date = $dataRow['starting_date'];
            $this->min_salary = $dataRow['min_salary'];
            $this->max_salary = $dataRow['max_salary'];
            $this->localisation = $dataRow['localisation'];
            $this->study_level = $dataRow['study_level'];
            $this->experience_years = $dataRow['experience_years'];
            $this->company_id = $dataRow['company_id'];
        }

        // UPDATE
        public function updateAdvertisement() {
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        title = :title,
                        description = :description,
                        contract_type = :contract_type,
                        starting_date = :starting_date,
                        min_salary = :min_salary,
                        max_salary = :max_salary,
                        localisation = :localisation,
                        study_level = :study_level,
                        experience_years = :experience_years,
                    WHERE
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->contract_type=htmlspecialchars(strip_tags($this->contract_type));
            $this->starting_date=htmlspecialchars(strip_tags($this->starting_data));
            $this->min_salary=htmlspecialchars(strip_tags($this->min_salary));
            $this->max_salary=htmlspecialchars(strip_tags($this->max_salary));
            $this->localisation=htmlspecialchars(strip_tags($this->localisation));
            $this->study_level=htmlspecialchars(strip_tags($this->study_level));
            $this->experience_years=htmlspecialchars(strip_tags($this->experience_years));
            
            // bind data
            $stmt->bindParam("title", $this->title);
            $stmt->bindParam("description", $this->description);
            $stmt->bindParam("contract_type", $this->contract_type);
            $stmt->bindParam("starting_date", $this->starting_date);
            $stmt->bindParam("min_salary", $this->min_salary);
            $stmt->bindParam("max_salary", $this->max_salary);
            $stmt->bindParam("localisation", $this->localisation);
            $stmt->bindParam("study_level", $this->study_level);
            $stmt->bindParam("experience_years", $this->experience_years);
            $stmt->bindParam("id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

        // DELETE
        function deleteAdvertisement() {
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);

            $this->id=htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id);

            if($stmt->execute()) {
                return true;
            }
            return false;
        }
    }
?>