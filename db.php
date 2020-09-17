<?php
include dirname(__FILE__) . "/config.php";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}