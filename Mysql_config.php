<?php

//!Database configuration
$dbHost = "localhost";
$dbUsername = "user";
$dbPassword = "user";
$dbName = "stock";

//!Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//!Check connection
if ($db->connect_error) {
    header("Location: http://localhost/phpisfun/Projet_gestion_de_stock/site_down/");
}
?>