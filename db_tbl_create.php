<?php
//functions to create new database table named users
$db_conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName) or die("Connection failed:". $db_conn->connect_error);

if($db_conn->connect_error){
    die("Connection failed:". $db_conn->connect_error);   
}

$sql_table = "CREATE TABLE $table_name (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(50)
    )";

if($db_conn->query($sql_table) == TRUE){
    fwrite(STDOUT, "\n Database Table $table_name has been created successfully \n");
}else{
    fwrite(STDOUT, "\n Error creating Database Table: ". $db_conn->error."\n");
}


?>
