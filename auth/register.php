<?php
error_reporting(E_ALL ^ E_WARNING);
// Turn off all error reporting
//error_reporting(0);
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;
require '../vendor/autoload.php';
require '../utils/fileutils.php';
$pdo = require_once '../connect.php';
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
//
$maxfilesize = 3000;//In KB
if ($_FILES["idProof"]["size"] > ($maxfilesize*1000)) {
	http_response_code(400);echo "id proof size should be less than $maxfilesize KB";die;
}
if ($_FILES["photo"]["size"] > ($maxfilesize*1000)) {
	http_response_code(400);echo "photo size should be less than $maxfilesize KB";die;
}
$photo = fileUtil($_FILES["photo"]);
$idProof = fileUtil($_FILES["idProof"]);

//INSERT DATA TO TABLE
$builder = new GenericBuilder();
$query = $builder->insert()
    ->setTable('users')
    ->setValues([
        'name' => $_POST["name"],
        'email'    => $_POST["email"],
        'phone'    => $_POST["phone"],
		'document_id'    => $_POST["document_id"],
		'gender'    => $_POST["gender"],
		'dob'    => $_POST["dob"],
		'role' => 'user',
		'verified' => 1,
		'idProof'=> $idProof,
		'photo' => $photo,
		'password' => $_POST["password"],
		'created_at' => date('Y-m-d H:i:s')
    ]);
//$sql = 'INSERT INTO users(name,email,phone,document_id,gender,dob,role,verified,idProof,photo,password,created_at) VALUES(:name)';
$sql = $builder->write($query);
//echo $sql;die;
$values = $builder->getValues();

try
{ 
	$statement = $pdo->prepare($sql);
	$statement->execute($values);
}
catch(PDOException $e)
{
   echo $e;die;
}

$insert_id = $pdo->lastInsertId();
http_response_code(405);
echo "user registered succesfully";

