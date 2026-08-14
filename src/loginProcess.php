<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "portfolio_blog";         // name of the database

    $conn = new mysqli($servername, $username, $password, $dbname);     // connecting

    // Checks connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // error msg
    }
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $pass = $_POST['password'];
                                                    // WHERE statement checks if email exisits in database
        $sql = "SELECT email, password, ID, first_name, last_name FROM USERS WHERE email = '$email' ";    // returns only one row with a given email
        $result = $conn->query($sql);   // execute the SQL query and store result (the retrieved data)

        if ($result->num_rows > 0) { // if a row was found
            $row = $result->fetch_assoc();  //fetch data from the row

            if ($row['password'] == $pass) {

                session_start();        // instructed to start a session upon correct login.

                $_SESSION['user_ID'] = $row['ID']; // declare a session variable, set session ID to user's ID
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_first'] = $row['first_name'];
                $_SESSION['user_last'] = $row['last_name'];
                $_SESSION['loggedIn'] = TRUE;

                header("Location: addEntry.php");     // sends user to addEntry.php
                
                exit;   // exits the PHP script
            }
            else {
                session_start();
                $_SESSION['incorrectPassword_error'] = TRUE;

                header("Location: login.php");     // sends user to login.php
                exit;   // exits the PHP script
            }
        }

        else {
            session_start();
            $_SESSION['accountNotFound_error'] = TRUE;

            header("Location: login.php");     // sends user to login.php
            exit;   // exits the PHP script
        }
    }
?>