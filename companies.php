<?php
    class Company{

        // Connection
        private $conn;

        // Table
        private $db_table = "company";

        // Columns
        public $id;
        public $name;
        public $logo;
        public $background;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCompanies(){
            $sqlQuery = "SELECT id, name, logo, background FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createCompany(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        logo = :logo, 
                        background = :background";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->logo=htmlspecialchars(strip_tags($this->logo));
            $this->background=htmlspecialchars(strip_tags($this->background));

            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":logo", $this->logo);
            $stmt->bindParam(":background", $this->background);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleCompany(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        logo, 
                        background 
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->logo = $dataRow['logo'];
            $this->background = $dataRow['background'];

        }        

        // UPDATE
        public function updateCompany(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        logo = :logo, 
                        background = :background 
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->logo=htmlspecialchars(strip_tags($this->logo));
            $this->background=htmlspecialchars(strip_tags($this->background));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":logo", $this->logo);
            $stmt->bindParam(":background", $this->background);
            $stmt->bindParam(":id", $this->id);

        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteCompany(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>