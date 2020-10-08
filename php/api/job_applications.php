<?php
    class JobApplication{

        // Connection
        private $conn;

        // Table
        private $db_table = "job_application";

        // Columns
        public $id;
        public $user_id;
        public $advertisement_id;
        public $name;
        public $email;
        public $phone;
        public $cv;
        public $message;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getJobApplications(){
            $sqlQuery = "SELECT id, user_id, advertisement_id, name, email, phone, cv, message FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createJobApplication(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        user_id = :user_id, 
                        advertisement_id = :advertisement_id, 
                        name = :name, 
                        email = :email, 
                        phone = :phone,
                        cv = :cv,
                        message = :message";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->advertisement_id=htmlspecialchars(strip_tags($this->advertisement_id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->cv=htmlspecialchars(strip_tags($this->cv));
            $this->message=htmlspecialchars(strip_tags($this->message));

            // bind data
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":advertisement_id", $this->advertisement_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":cv", $this->cv);
            $stmt->bindParam(":message", $this->message);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleJobApplication(){
            $sqlQuery = "SELECT
                        id, 
                        user_id, 
                        advertisement_id, 
                        name, 
                        email, 
                        phone,
                        cv,
                        message
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->user_id = $dataRow['user_id'];
            $this->advertisement_id = $dataRow['advertisement_id'];
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->phone = $dataRow['phone'];
            $this->cv = $dataRow['cv'];
            $this->message = $dataRow['message'];

        }        

        // UPDATE
        public function updateJobApplication(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        user_id = :user_id, 
                        advertisement_id = :advertisement_id, 
                        name = :name, 
                        email = :email, 
                        phone = :phone,
                        cv = :cv,
                        message = :message
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->advertisement_id=htmlspecialchars(strip_tags($this->advertisement_id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->cv=htmlspecialchars(strip_tags($this->cv));
            $this->message=htmlspecialchars(strip_tags($this->message));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":advertisement_id", $this->advertisement_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":cv", $this->cv);
            $stmt->bindParam(":message", $this->message);
            $stmt->bindParam(":id", $this->id);

        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteJobApplication(){
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