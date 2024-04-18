# CSV to MySQL Importer

This PHP script is designed to be run from the command line, accepting a CSV file as input and inserting its content into a MySQL database. It's specifically tailored to handle user data with a robust validation system for data integrity.

## Features

- **CSV Input**: Accepts a CSV file containing user data with three specific columns: `name`, `surname`, and `email`.
- **Database Integration**: Each record from the CSV file is inserted into the `users` table in a MySQL database.
- **Data Transformation**:
  - The `name` and `surname` fields are capitalized (e.g., "john" to "John").
  - The `email` addresses are converted to lowercase.
- **Email Validation**: Validates each email address to ensure it conforms to acceptable email formats. Invalid emails are not inserted, and an error message is output to STDOUT.
- **Database Table Management**: Includes directives to create or rebuild the `users` table as part of the script's execution.

## Command Line Usage

To use this script, you should provide the CSV file as an argument when running the script from your command line:

```bash
php import_users.php path_to_your_file.csv
