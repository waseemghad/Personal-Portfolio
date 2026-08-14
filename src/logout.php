<?php
    session_start();

    session_unset();
    // $_SESSION['loggedIn'] will also be unset

    header("Location: index.html");     // sends user to index.html
    exit;   // Exits php script
?>