<?php
error_reporting(0);// Not showing php exceptionale error
//php script that is executed from command line that accepts a CSV file and process its to insert ino DB table

//############### long and short Script command line directives 
    // Long Options directives
    $longoptions  = array(
        "file:",            // name of CSV file to be parsed --file "users.csv"
        "create_table:",    // this will create table with the table name --create_table "users"
        "dry_run:",          // with value check
        "help",             // this will give the help instruction with the directives options --help
    );

    // Short Options directives
    $shortoptions  = "";
    $shortoptions .= "u::"; // MYSQL username -u="root"
    $shortoptions .= "p::"; // MYSQL password -p="*******"
    $shortoptions .= "h::"; // MYSQL hostname -h="localhost"

    $options = getopt($shortoptions, $longoptions); //to get options from the command line argument list
    
    execution_command($options);// calling custom function to check the right command input has given and continue

    if(array_key_exists("help",$options)){
        $help = $options['help'];
        if($help == false){ //condition to get --help directives and execute showing help message and exit.
            include_once("help.php");
        }
    }
    $dir = getcwd();//"php function to give the current working directory "var/www/html/catalystIT/" 
    $csv_file = $options['file'];
    $csv_explode = explode(".", $csv_file);
    if($csv_explode[0] == "users"){
        $csv_file = $csv_file;
    }else{
        fwrite(STDOUT, "\n File name incorrect | Must be users.csv : ERROR! \n");
        exit();
    }

    if(array_key_exists("dry_run",$options) && array_key_exists("file",$options)){
        $dry_run = $options['dry_run'];
        
        if($dry_run != false){ //condition to get --help directives and execute showing help message and exit.
            execute_testing($dry_run, $dir, $csv_file);
        }else{
            //if dry run is disabled, then execute the command
            fwrite(STDOUT, "\n both exist Error in your execution command: \n Please check --help command (php user_upload.php --help) \n");
        }
        exit();
    }

    $mysql_username = $options['u'];
    $mysql_password = $options['p'];
    $mysql_hostname = $options['h'];
    
    $create_table = $options['create_table'];
    
    

//############### long and short command line directives 

// variable assignin by reference from command line directives
$dbHost = "$mysql_hostname";
$dbUsername = "$mysql_username";
$dbPassword = "$mysql_password";
$dbName = "catalyst";// assigned default database name 
$table_name = "$create_table";

include('db_create.php');
include('db_tbl_create.php');

if(is_dir($dir)){
    if ($dh = opendir($dir)) {
        
        $dir_path = $dir."/"."$csv_file"; // csv file path /var/www/html/catalystIT/users.csv
        
        $file_info = pathinfo($dir_path); //pathinfo return array value of file information
        $file_ext = $file_info['extension'];
        if(!empty($file_ext) && $file_ext == "csv"){

            $csvFile = fopen($dir_path,'r');
            
            $countRows = 0;
            
            while(($row_line = fgetcsv($csvFile, 1000, ",")) !== FALSE){

                $name = $row_line[0];
                $surname = $row_line[1];
                $email = $check_email = $row_line[2];

                $name = ucfirst_trim($name);
                $surname = ucfirst_trim($surname);
                
                if($name != "Name" || $surname != "Surname"){// Condition to exclude first line of parsed CSV file which has column indexing name that should'nt be inserted in the DB table

                    $email = validation($email); // validation function call to validate email filters
                    
                    //if only email validate insertion of data occurs
                    if($email == TRUE){    
                    
                        $insert_sql = 'INSERT INTO users ( id, `name`, `surname`, `email` ) VALUES ( null, "'.$name.'", "'.$surname.'", "'.$email.'" )';
                    
                       // echo $insert_sql;die;
                        if($db_conn->query($insert_sql) == TRUE){
                            $countRows++;
                        }else{
                            fwrite(STDOUT,  "Error inserting into Table $name:". $db_conn->error);
                        }
                    }else{
                        fwrite(STDOUT, "\n \n $check_email Email Validation failed!!! \n");
                    }       
                } 
            
            }
        }else{
            fwrite(STDOUT, "\n File found on the directory is not .CSV file format: ERROR! \n");
        }    
        if(!empty($countRows)){
            fwrite(STDOUT, "\n Total:$countRows number of rows has been inserted \n");
        }
        
    }
}

//function to validate email using filter function of php
function validation($input_email){
    $input_email = trim($input_email);// removing the unwanted space from the strings
    $input_email = strtolower($input_email); //string to lower case

    return filter_var($input_email, FILTER_VALIDATE_EMAIL);// filter_var php function to filter the email
}

//function to trim and make first letter capitalised
function ucfirst_trim($values){
    $values = trim($values);// removing the unwanted space from the strings
    $values = strtolower($values); //string to lower case
    $values = ucfirst($values); //strings first character to be capitalised
    return $values;
}

//function for testing the runable code into your environment
function execute_testing($dry_run, $dir, $csv_file){
    //if dry run is enabled then simply return 
    if($dry_run == "check"){
        if(is_dir($dir)){
            if ($dh = opendir($dir)) {
                
                $dir_path = $dir."/"."$csv_file"; // csv file path /var/www/html/catalystIT/users.csv
                $file_info = pathinfo($dir_path);
                $file_ext = $file_info['extension'];
                if(!empty($file_ext) && $file_ext == "csv"){
                    $csvFile = fopen($dir_path,'r');
                    
                    $counter = 0;
                    while(($row_line = fgetcsv($csvFile, 1000, ",")) !== FALSE){ $counter++;}
                    
                    if($counter> 0){
                        fwrite(STDOUT, "\n File found on the directory and your code reading tested: SUCCESS! \n");
                    }
                }else{
                    fwrite(STDOUT, "\n File found on the directory is not .CSV file format: ERROR! \n");
                }
            }
        }
    }else{
    //if dry run is disabled, then execute the command
    fwrite(STDOUT, "\n execute function  Error in your execution command: \n Please check --help command (php user_upload.php --help) \n");
    }
    exit();
}

function execution_command($options){
    //var_dump($options);
    if(empty($options)){
        fwrite(STDOUT, "\n Error in your execution command series: \n Please check --help command (php user_upload.php --help) \n");
        echo "\n 1 \n";
        exit();
    }else if( (array_key_exists("help",$options)) || (array_key_exists("dry_run",$options) && array_key_exists("file",$options)) || (array_key_exists("file",$options) && array_key_exists("create_table",$options) && array_key_exists("u",$options) && array_key_exists("p",$options) && array_key_exists("h",$options)) ){
        // continue; to work
        return 0;
        //echo "\n 2 \n";
        
    }else{
        //echo "\n 3 \n";
        fwrite(STDOUT, "\n Error in your execution command series: \n Please check --help command (php user_upload.php --help) \n");
        exit();
    }
    //die;
}


$db_conn->close();//closing the database connection after executing above statements
?>
