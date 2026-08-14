<?php
session_start();

// DEFENSIVE - check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "portfolio_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'] ?? null;
    $userComment = $_POST['userComment'] ?? null;
    
    // Validate input
    if (!$postId || !$userComment) {
        echo "Error: Missing post ID or comment text.";
        exit;
    }
    
    // Get user details from session
    $firstName = $_SESSION['user_first'] ?? '';
    $lastName = $_SESSION['user_last'] ?? '';
    $email = $_SESSION['user_email'] ?? '';
    
    // Escape special characters in user input for SQL
    $userComment = $conn->real_escape_string($userComment);
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $email = $conn->real_escape_string($email);
    
    // Insert comment into COMMENTS table
    $sql = "INSERT INTO COMMENTS (postId, firstName, lastName, email, userComment)
            VALUES ($postId, '$firstName', '$lastName', '$email', '$userComment')";
    
    if ($conn->query($sql) === TRUE) {
        // Comment inserted successfully
        header("Location: viewBlog.php");
        exit;
    } else {
        echo "Error inserting comment: " . $conn->error;
    }
}

$conn->close();
?>
