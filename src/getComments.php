<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "portfolio_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postId = $_GET['postId'] ?? null;

if (!$postId) {
    echo "<p>No post ID provided.</p>";
    exit;
}

// Fetch comments for this post
$sql = "SELECT firstName, lastName, userComment, createdAt FROM COMMENTS WHERE postId = $postId ORDER BY createdAt DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {    // Return delimited text
        $name = $row['firstName'] . ' ' . $row['lastName'];
        $comment = $row['userComment'];  // Keep newlines as-is
        $time = date('jS F Y, H:i', strtotime($row['createdAt'])) . ' UTC';
        echo $name . "|" . $comment . "|" . $time . "||";  // Separate comments with ||
    }   // Each comment ends with ||
} else {
    echo "";    // Return empty string if no comments
}

$conn->close();
?>