<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Registration";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 

//Custom function to execute and return result of a Query
function query($sql){
    global $db;
    $result = $db->query($sql);
    if ($result) {
        return $result;
    } else {
        die("Error executing query: ".$sql."<br>". $db->error);
    }
}

?>
