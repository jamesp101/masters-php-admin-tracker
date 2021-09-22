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

echo $query;



