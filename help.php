<?php
//file to show help messages that will asked by command directives
$help_message = "
++++++ Script Command Line Directive Details ++++++

--file 'users.csv'      - This is name of the CSV file to be parsed
--create_table 'users'  - This will create users table to be built
-u='root'               - This is MYSQL username
-p='*******'            - This is MYSQL password
-h='localhost'          - This is MYSQL host name
--help                  - This will gives you directives list directions and its details
--dry_run check         - This command is to check the program running in your environment

How you should run in command line interface to run smoothly?

- go to your directives -> cd /var/www/html/catalystIT/
- run you file -> php user_upload.php --file 'users.csv' --create_table 'users' -u='root' -p='*****' -h='localhost'
- run to get help -> php user_upload.php --help

NOTE : you cannot empty or miss the serial of code 
php user_upload.php --file 'users.csv' --create_table 'users' -u='root' -p='*****' -h='localhost'
\n 
-u='root'
-p='*****'
-h='localhost'
(must have '=' sign in between variabel name and value)
\n
--dry_run test
(dry_run command must have 'test' word to work properly)
";

fwrite(STDOUT, $help_message);
exit();
?>