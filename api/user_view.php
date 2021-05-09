<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

 
include_once '../config/Database.php';
 
$database = new Database();
$db = $database->getConnection();

$id = $_POST['id'];
$sql = 'SELECT * FROM users where id='.$id;
$result = $db->query($sql);

if($result->num_rows > 0)
{
    $user_records=array();
    $user_records["users"]=array(); 
	while ($user = $result->fetch_assoc()) { 	
        extract($user); 
        $user_details=array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
			"first_name" => $first_name,
            "last_name" => $last_name,            
			"dob" => $dob,
            "age" => $age,
            "address_line1" => $address_line1,
            "address_line2" => $address_line2,
            "address_line3" => $address_line3,
            "phone" => $phone							
        ); 
       array_push($user_records["users"], $user_details);
    }    
    http_response_code(200);     
    echo json_encode($user_records);
}   
else{
    http_response_code(404);     
    echo json_encode(
        array("message" => "No user found.")
    );
}


?>