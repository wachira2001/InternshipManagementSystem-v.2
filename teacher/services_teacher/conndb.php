<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internshipmanagementsystem";

//$servername = "db4free.net:3306";
//$username = "admin20012544";
//$password = "@admin2001";
//$dbname = "db_ims_online";



try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
date_default_timezone_set('Asia/Bangkok');
?>