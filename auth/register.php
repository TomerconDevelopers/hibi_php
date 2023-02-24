<?php
require "../utils/fileutils.php";
// Turn off all error reporting
//error_reporting(0);
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
if(!isset($_FILES["idProof"])){http_response_code(400);echo "id proof required";die;}
if(!isset($_FILES["photo"])){http_response_code(400);echo "photo required";die;}

$photo = fileUtil($_FILES["photo"]);
$idProof = fileUtil($_FILES["idProof"]);
	
http_response_code(405);
echo "photo: $photo, idProof: $idProof";

