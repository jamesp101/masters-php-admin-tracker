<?php
require __DIR__ . '/../connection.php';

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);


$query = "UPDATE  personsqr_tbl SET " . 
                "status =  '" . $data['status'] ."',
                 dateUpdated = NOW() 
                 WHERE RandomID = '". $data['id'] ."'" ;

if ($conn -> query ($query))
{
    echo 'Updated!';

}
else{
    echo 'Something went wrong';

}


$insert = "INSERT INTO history " .
    " (user_id, status, date_updated )" .
    " VALUES " .
    " ( '" . $data['id'] . "', '" . $data['status'] . "',  NOW() );";

if ($conn->query($insert)) {
    echo 'Updated!';
} else {
    echo $conn->error;
    http_response_code(404);
    die();
}


echo $query;



