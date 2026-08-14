<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/reset.css">
    <link rel="stylesheet" type="text/css" href="CSS/main.css">
    <link rel="stylesheet" type="text/css" href="CSS/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="JS/login.js" defer></script>
    <title>Login to My Blog</title>
</head>
<body id="fullFlex">
    <div id="headgrid">
        <header>        <!-- -->
            <h1>Waseem Ghadari</h1>
        </header>

        <nav id="nav_id">
            <ul id="navlist">
                <li><a href="index.html">About Myself</a></li>
                <li><a href="portfolio.html">Projects</a></li>
                <li><a href="education.html">Education</a></li>
                <li><a href="skills.html">Skills</a></li>
                <li><a href="viewBlog.php">Blog</a></li>
            </ul>
        </nav>
    </div>
    <main>
        <h1 id="hlo">My Blog</h1>
        </br>
        <form method="post" action="loginProcess.php">
            <fieldset>
                <legend>Login Details</legend>
                <div class="fieldsDiv">
                    <label>Email</label>
                    <input type="email" name="email"> <!--'required' not added - handled by JS-->
                </div>
                </br>
                <div class="fieldsDiv">
                    <label>Password</label>
                    <input type="password" name="password">
                </div>
                <input type="submit" value="Login">
                <a href="register.html">
                    <button type="button" class="registerBtn">Register</button>
                </a>
                <?php
                    if (isset($_SESSION['accountNotFound_error']) || isset($_SESSION['incorrectPassword_error'])) {
                        echo '<aside>';
                        if (isset($_SESSION['accountNotFound_error']) && $_SESSION['accountNotFound_error']) {  
                            echo 'Account not found.';
                            unset($_SESSION['accountNotFound_error']);
                        }
                        if (isset($_SESSION['incorrectPassword_error']) && $_SESSION['incorrectPassword_error']) {
                            echo 'Incorrect password.';
                            unset($_SESSION['incorrectPassword_error']);
                        }
                        echo '</aside>';
                    }
                ?>
            </fieldset>
        </form>
    </main>
</body>
</html>