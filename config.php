<?php


$host = 'mysql-gestionservices.alwaysdata.net';
$dbname = 'gestionservices_gestion';
$username = '377253';
$password = 'assia08012004';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
