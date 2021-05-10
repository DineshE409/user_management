<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 
include_once '../config/Database.php';
 
$database = new Database();
$db = $database->getConnection();


$email = $_POST['login_email'];
$password = md5($_POST['login_password']);

if(!empty($email) && !empty($password) )
{
    $sql = 'SELECT * FROM users where email="'.$email.'" and password="'.$password.'"';
    $result = $db->query($sql);
    if($result->num_rows > 0)
    {
        http_response_code(200);         
        echo json_encode(array("message" => "Login successful"));
    }   
    else{
        http_response_code(401);         
        echo json_encode(array("message" => "Invalid username or password"));
    }
}
else
{
    http_response_code(400);    
    echo json_encode(array("message" => "Parameter Missing"));
}


?>