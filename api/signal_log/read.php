 <?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 // include database and object files
include_once '../config/database.php';
include_once '../objects/signal_log.php';
  
// instantiate database and signal_log object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$signal_log = new signal_log($db);
  
// query signal_log
$stmt = $signal_log->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // signal_log array
    $signal_log_arr=array();
    $signal_log_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['longitude'] to
        // just $longitude only
        extract($row);
  
        $signal_log_item=array(
            'latitude' => $latitude,
            'longitude' => $longitude,
            'strength' => $strength,
            'operator' => $operator
        );
  
        array_push($signal_log_arr["records"], $signal_log_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show signal_log data in json format
    echo json_encode($signal_log_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no signal_log found
    echo json_encode(
        array("message" => "No signal_log found.")
    );
}
?>
