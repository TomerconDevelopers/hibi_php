<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$key = 'example_key';
//ACCEPT POST REQUEST ONLY
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	http_response_code(405);echo "accepts post request only";die;
}
//
if(!isset($_POST["name"])){http_response_code(400);echo "No name specified";die;}
if(!isset($_POST["email"])){http_response_code(400);echo "No email specified";die;}
if(!isset($_POST["phone"])){http_response_code(400);echo "No phone specified";die;}
if(!isset($_POST["document_id"])){http_response_code(400);echo "No document id specified";die;}
if(!isset($_POST["gender"])){http_response_code(400);echo "No gender specified";die;}
if(!isset($_POST["dob"])){http_response_code(400);echo "No dob specified";die;}
if(!isset($_POST["password"])){http_response_code(400);echo "No password specified";die;}
//
//http_response_code(405);
//echo "stuck";die;
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
//
//move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
$temp = explode(".", $_FILES["photo"]["name"]);
$newphotoname = round(microtime(true)) . '.' . end($temp);
if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $newphotoname)){
	//echo "success";
	http_response_code(405);
	echo "null";
}
else{
	http_response_code(405);
	echo "error uploading file";die;
}