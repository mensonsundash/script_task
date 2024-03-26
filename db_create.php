<?php
//functions to create new database named catalyst
$db_conn = new mysqli($dbHost, $dbUsername, $dbPassword) or die("Connection failed:". $db_conn->connect_error);

if($db_conn->connect_error){
    die("Connection failed:". $db_conn->connect_error);   
}

$sql = "CREATE DATABASE $dbName";

if($db_conn->query($sql) == TRUE){
    fwrite(STDOUT, "\n Database: $dbName has been created successfully.\n");
}else{
    fwrite(STDOUT, "\n Error creating Database: ". $db_conn->error ."\n");
}
?>
