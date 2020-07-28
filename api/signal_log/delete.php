<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/signal_log.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare signal_log object
$signal_log = new signal_log($db);
  
// get signal_log latitude
$data = json_decode(file_get_contents("php://input"));
  
// set signal_log latitude to be deleted
$signal_log->latitude = $data->latitude;
  
// delete the signal_log
if($signal_log->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "signal_log was deleted."));
}
  
// if unable to delete the signal_log
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete signal_log."));
}
?>