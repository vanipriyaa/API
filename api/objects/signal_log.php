<?php
class signal_log{
  
    // database connection and table name
    private $conn;
    private $table_name = "signal_log";
  
    // object properties
    public $latitude;
    public $longitude;
    public $strength;
    public $operator;
    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
// read signal_log
function read(){
  
    // select all query
    $query = "SELECT
                 p.latitude, p.longitude, p.strength, p.operator
            FROM
                " . $this->table_name . " p";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
} 
// create signal_log
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
              latitude=:latitude, longitude=:longitude, strength=:strength, operator=:operator ";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
      $this->latitude=htmlspecialchars(strip_tags($this->latitude));
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));
    $this->strength=htmlspecialchars(strip_tags($this->strength));
    $this->operator=htmlspecialchars(strip_tags($this->operator));
    
  
    // bind values
    $stmt->bindParam(':latitude', $this->latitude);
    $stmt->bindParam(':longitude', $this->longitude);
    $stmt->bindParam(':strength', $this->strength);
    $stmt->bindParam(':operator', $this->operator);
   
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// update the signal_log
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                longitude = :longitude,
                strength = :strength,
                operator = :operator
            WHERE
                latitude = :latitude";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->longitude=htmlspecialchars(strip_tags($this->longitude));
    $this->strength=htmlspecialchars(strip_tags($this->strength));
    $this->operator=htmlspecialchars(strip_tags($this->operator));
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));  
   
  
    // bind new values
    $stmt->bindParam(':longitude', $this->longitude);
    $stmt->bindParam(':strength', $this->strength);
    $stmt->bindParam(':operator', $this->operator);
    $stmt->bindParam(':latitude', $this->latitude);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the signal_log
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE latitude = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->latitude=htmlspecialchars(strip_tags($this->latitude));
  
    // bind latitude of record to delete
    $stmt->bindParam(1, $this->latitude);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}

              
    
