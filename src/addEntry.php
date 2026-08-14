<?php
    session_start();

    // DEFENSIVE
    if (! isset($_SESSION['loggedIn'])) {
        header("Location: login.php");
        exit;
    }

    // If the user previewed a draft, prefill the form fields from session
    $draft = $_SESSION['preview_post'] ?? null;
    $draftTitle = $draft['postTitle'] ?? '';
    $draftContent = $draft['postContent'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/reset.css">
    <link rel="stylesheet" type="text/css" href="CSS/main.css">
    <link rel="stylesheet" type="text/css" href="CSS/addEntry.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="JS/addEntry.js" defer></script>
    <title>My Blog</title>
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

    <aside>
        <h3>Welcome to my blog.</h3>
        <section>
            <p>Logged in as:</p>
            <p id="user">
                <?php echo $_SESSION['user_first'] .' '. $_SESSION['user_last'] .' ('. $_SESSION['user_email'] .')' ?>
            </p>
            <a href="logout.php">
                <button class="buttonClass">Logout</button>
            </a>
        </section>
    </aside>

    <form method="post" action="addPost.php">
        <fieldset>
            <legend>Add Blog</legend>
            <div id="titleDiv">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($draftTitle, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div id="blogDiv">
                <label for="content">Content:</label>
                <textarea name="content" id="textbox" rows="15" placeholder="Write your blog post here..."><?php echo htmlspecialchars($draftContent, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <div id="buttons">
                <button type="button" id="clear">Clear</button><!--"action" for Preview/Post-->
                <button type="submit" id="preview" name="action" value="preview">Preview</button>
                <button type="submit" id="post" name="action" value="post">Post</button>
            </div>
        </fieldset>
    </form>

    <footer id="footerFlex">        <!-- -->
        <p>Waseem Hemat Ghadari</p>
        <div id="iconsDiv">
            <a href="https://www.github.com/waseemghad">
                <img class="icons" src="PNGimage/github_red.png" alt="my GitHub">
            </a>
            <a href="https://www.linkedin.com/in/waseem-hemat-ghadari-518747372/">
                <img class="icons" src="PNGimage/linkedin_red.png" alt="my Linkedin">
            </a>
        </div>
        <p>Updated on 27 Apr 2026</p>
    </footer>
</body>
</html>

<?php
// Clear draft after page renders so it doesn't persist on future visits
unset($_SESSION['preview_post']);
?>