<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate signal_log object
include_once '../objects/signal_log.php';
  
$database = new Database();
$db = $database->getConnection();
  
$signal_log = new signal_log($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->latitude)&&
    !empty($data->longitude) &&
    !empty($data->strength) &&
    !empty($data->operator)
){
  
    // set signal_log property values
     $signal_log->latitude = $data->latitude;
     $signal_log->longitude = $data->longitude;
    $signal_log->strength = $data->strength;
    $signal_log->operator = $data->operator;
    
  
    // create the signal_log
    if($signal_log->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "signal_log was created."));
    }
  
    // if unable to create the signal_log, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create signal_log"));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create signal_log. Data is incomplete."));
}
?>