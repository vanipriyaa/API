<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once'../objects/signal_log.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare signal_log object
$signal_log = new signal_log($db);
  
// get latitude of signal_log to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set latitude property of signal_log to be edited
$signal_log->latitude = $data->latitude;
  
// set signal_log property values
$signal_log->longitude= $data->longitude;
$signal_log->strength = $data->strength;
$signal_log->operator = $data->operator;

  
// update the signal_log
if($signal_log->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "signal_log was updated."));
}
  
// if unable to update the signal_log, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update signal_log."));
}
?>