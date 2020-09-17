<?php
include dirname(__FILE__) . "\..\db.php";

$tmp_name = $_FILES['file']['tmp_name'];
$name = $_FILES['file']['name'];
$path = dirname(__FILE__) . "\..\uploaded_files\\" . $name;

$url = DOMAIN . "/uploaded_files/" . $name;

$upload_file = $pdo->prepare("INSERT INTO uploaded_files(url) VALUES('$url')");
$upload_file->execute();

move_uploaded_file($tmp_name, $path);

header("location: " . DOMAIN);