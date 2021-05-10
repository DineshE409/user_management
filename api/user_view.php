<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 
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
    $user = $result->fetch_assoc();
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

    $sql_previous = 'select * from users where id = (select max(id) from users where id < '.$id.')';
    $result_previous = $db->query($sql_previous);
    if($result_previous->num_rows > 0)
    {
        $previous_user = $result_previous->fetch_assoc();
        $user_records["prev"] = array("id" => $previous_user["id"]);
    }
    else{
        $user_records["prev"] = array();
    }
    
    $sql_next = 'select * from users where id = (select min(id) from users where id > '.$id.')';
    $result_next = $db->query($sql_next);
    
    if($result_next->num_rows > 0)
    {
        $next_user = $result_next->fetch_assoc();
        $user_records["next"] = array("id" => $next_user["id"]);
    }
    else{
        $user_records["next"] = array();
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