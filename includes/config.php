<?php
ob_start(); // Turns in output buffering
session_start();

date_default_timezone_set("Asia/Ho_Chi_Minh");

try {
    $con = new PDO("mysql:dbname=reeceflix;host=localhost","root","");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}

?>