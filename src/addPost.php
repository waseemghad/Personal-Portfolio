<?php
    session_start();

    // DEFENSIVE
    if (! isset($_SESSION['user_email'])) {
        header("Location: login.php");
        exit;
    }

    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "portfolio_blog";         // name of the database

    $conn = new mysqli($servername, $username, $password, $dbname);     // connecting

    // Checks connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // error msg
    }

// INSERTING INTO THE DATABASE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // if $_POST['action'] not exists, then $action just = 'post'
    $action = $_POST['action'] ?? 'post';

    $fname = $_SESSION['user_first'];
    $lname = $_SESSION['user_last'];
    $email = $_SESSION['user_email'];
                                    // Keep raw input for preview/session; escape only when inserting into DB
    $rawTitle = $_POST['title'] ?? '';
    $rawContent = $_POST['content'] ?? '';
    // escape characters (e.g. ') that can break the SQL query, for a safe parsing.
    $title = $conn->real_escape_string($rawTitle);
    $content = $conn->real_escape_string($rawContent);
    $fname = $conn->real_escape_string($fname);
    $lname = $conn->real_escape_string($lname);
    $email = $conn->real_escape_string($email);

    if ($action === 'preview') {    // Store post array as a 'preview' session variable

        $_SESSION['preview'] = TRUE;

        $_SESSION['preview_post'] = [
            'firstName' => $fname,
            'lastName' => $lname,
            'email' => $email,
            // store raw values so they are not pre-escaped for SQL
            'postTitle' => $rawTitle,
            'postContent' => $rawContent,
        ];

        header("Location: viewBlog.php");
        exit;
    }


    // 'createdAt' (date) gets filled automatically
    $sql = "INSERT INTO BLOG_POSTS (firstName, lastName, email, postTitle, postContent)
     VALUES ('$fname', '$lname', '$email', '$title', '$content')";


        // string is sent over to the database in if statement
    if ($conn->query($sql) === TRUE) {       // if post is successfully registered

    unset($_SESSION['preview_post']); // clears session variable


    // $conn->insert_id returns the ID of the most recent post (post id)
    // Comments will be stored in a single COMMENTS table linked by the post id


    header("Location: viewBlog.php");
    exit;   // exits the PHP script

    } else {                            // shows what error occured e.g. 'table doesn't exist'
    echo "Unable to connect to the database. Check network connection.";
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }
?>