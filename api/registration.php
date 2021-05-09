<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

 
include_once '../config/Database.php';
 
$database = new Database();
$conn = $database->getConnection();

$name = $_POST['name'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = md5($_POST['password']);
$dob = date("Y-m-d", strtotime($_POST['dob']));
$age = $_POST['age'];
$address_line1 = $_POST['address_line1'];
$address_line2 = $_POST['address_line2'];
$address_line3 = $_POST['address_line3'];
$phone = $_POST['phone'];
print_r($_POST['dob']);
print_r($dob);

if(!empty($name) && !empty($email) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($dob) && !empty($age) && !empty($address_line1) && !empty($address_line2) && !empty($address_line3) && !empty($phone) ){ 

    $sql_query = 'SELECT * FROM users where email="'.$email.'"';
    $result_query = $conn->query($sql_query);
    if($result_query->num_rows > 0)
    {
        http_response_code(409);         
        echo json_encode(array("message" => "Email already exists"));
    }
    else
    {
        $sql = 'INSERT INTO users (name, email , first_name,last_name,password,dob,age,address_line1,address_line2,address_line3,phone)
        VALUES ("'.$name.'","'.$email.'","'.$first_name.'","'.$last_name.'","'.$password.'","'.$dob.'",'.$age.',"'.$address_line1.'","'.$address_line2.'","'.$address_line3.'","'.$phone.'")';

        if ($conn->query($sql) === TRUE) {
            http_response_code(201);         
            echo json_encode(array("message" => "Registered successfully"));
        } else {
            http_response_code(503);        
            echo json_encode(array("message" => "Unable to create user"));
        }
    }
    
    
}
else{
    http_response_code(400);    
    echo json_encode(array("message" => "Parameter Missing"));
}

?>