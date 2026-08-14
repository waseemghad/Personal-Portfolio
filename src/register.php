<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "portfolio_blog";         // name of the database
    // Creates connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Checks connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // INSERTING INTO THE DATABASE
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
                                                                    //'USERS' is the table within the satabase
    $sql = "INSERT INTO USERS (first_name, last_name, email, password)
     VALUES ('$fname', '$lname', '$email', '$pass')";               // $sql string created with SQL functions
    
        // string is sent over to the database in if statement
    if ($conn->query($sql) === TRUE) {       // if successful registry
    
    header("Location: login.php");     // sends user to login.php
    exit;   // exits the PHP script

    } else {                            // shows what error occured e.g. 'table doesn't exist'
    echo "Unable to connect to the database. Check network connection.";
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }
?>