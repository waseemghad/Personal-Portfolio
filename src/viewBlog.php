<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "portfolio_blog";

$conn = new mysqli($servername, $username, $password, $dbname); // connect to database

if ($conn->connect_error) {     // error msg
    die("Connection failed: " . $conn->connect_error);
}

$addEntryTarget = (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE)
    ? 'addEntry.php'    // if
    : 'login.php';      // else

$loginTarget = (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE)
    ? 'logout.php'      // if
    : 'login.php';      // else

$posts = [];    // blog posts array
$sql = "SELECT ID, firstName, lastName, createdAt, postTitle, postContent FROM BLOG_POSTS";
$result = $conn->query($sql);   // send sql string to fetch row of data

if ($result !== false) {
    while ($row = $result->fetch_assoc()) { // while a row is retrieved (null when rows end)
            /* fetch_assoc() returns an associative array where the keys match the column names */
        $posts[] = $row;    // append $row to $posts[]
    }
}

// recieves two array halves, sorts them in the correct order
function mergePostsByCreatedAt(array $left, array $right): array
{
    $merged = [];

    while (!empty($left) && !empty($right)) {
        $leftTime = strtotime($left[0]['createdAt']);
        $rightTime = strtotime($right[0]['createdAt']);

        if ($leftTime >= $rightTime) {
            $merged[] = array_shift($left);
        } else {
            $merged[] = array_shift($right);
        }
    }

    return array_merge($merged, $left, $right);
}

// sorts an array into order
function sortPostsNewestFirst(array $posts): array
{
    $count = count($posts);

    if ($count <= 1) {
        return $posts;
    }

    $middle = intdiv($count, 2);

    $left = array_slice($posts, 0, $middle);
    $right = array_slice($posts, $middle);

    return mergePostsByCreatedAt(
        sortPostsNewestFirst($left),
        sortPostsNewestFirst($right)
    );
}

$posts = sortPostsNewestFirst($posts);

// if not exists (undefined), give value 'null'
$previewPost = $_SESSION['preview_post'] ?? null;

$preview = $_SESSION['preview'] ?? FALSE;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS/reset.css">
    <link rel="stylesheet" type="text/css" href="CSS/main.css">
    <link rel="stylesheet" type="text/css" href="CSS/viewBlog.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="JS/viewBlog.js" defer></script>
    <title>My Blog</title>
</head>
<body id="fullFlex" data-preview="<?php echo $preview ? 'true' : 'false'; ?>"><!--sends whether user is previewing to JS-->
    <div id="headgrid">
        <header>
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
        <div id="buttons">
            <h1>My Blog</h1>    <!-- link to login, if logged in link to addEntry -->
            
            <div id="topRowBtns">
                <a href= "<?php echo $loginTarget ?>" >
                    <?php
                        echo '<button type="button" id="loginBtn">';
                        if (isset($_SESSION['loggedIn']))
                            echo 'Logout';
                        else
                            echo 'Login';
                        echo '</button>';
                    ?>
                </a>
                <a href= "<?php echo $addEntryTarget; ?>" >
                    <?php
                        echo '<button type="button" id="addPostBtn">';
                        if ($preview)
                            echo 'Return';
                        else
                            echo 'Add Post';
                        echo '</button>';
                    ?>
                </a>
            </div>
        </div>
        <?php if ($preview)
                echo '<p id="previewMsg">Preview only.</p>'; ?>

        <article id="flexPage">
            <?php if ($preview): // Section for Preview post 
                $previewDateTime = new DateTime('now', new DateTimeZone('UTC'));
                $previewDisplayDate = $previewDateTime->format('jS F Y, G:i') . ' UTC';
            ?>
                <section>
                    <h2><?php echo htmlspecialchars($previewPost['postTitle']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($previewPost['postContent'])); ?></p>
                    <div id="postInfo">
                        <p>
                            <?php echo htmlspecialchars($previewPost['firstName'] . ' ' . $previewPost['lastName']); ?>
                            <br>
                            <?php echo htmlspecialchars($previewDisplayDate); ?>
                        </p>
                        <button id=commBtn>Comments</button>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?> <!-- loop through each post -->
                    <?php
                        $createdAt = new DateTime($post['createdAt'], new DateTimeZone('UTC')); // create a DateTime
                        $displayDate = $createdAt->format('jS F Y, G:i') . ' UTC'; // format it
                    ?>
                    <section data-post-id="<?php echo $post['ID']; ?>"><!--gives each post its ID, needed for JS-->
                        <h2><?php echo htmlspecialchars($post['postTitle']); ?></h2> <!--PHP to HTML formatting-->
                        <p><?php echo nl2br(htmlspecialchars($post['postContent'])); ?></p>
                        <div id="postInfo">
                            <p>
                                <?php echo htmlspecialchars($post['firstName'] . ' ' . $post['lastName']); ?>
                                <br>
                                <?php echo htmlspecialchars($displayDate); ?>
                            </p>
                            <button id=commBtn>Comments</button>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php elseif (empty($posts) && $previewPost === null): ?>  <!-- else if no posts -->
                <section>
                    <h2>No posts yet</h2>
                    <p>Be the first to add one.</p>
                </section>
            <?php endif // (closes if statement); ?>
        </article>
    </main>

    <footer id="footerFlex">
        <p>Waseem Hemat Ghadari</p>
        <div id="iconsDiv">
            <a href="https://www.github.com/waseemghad">
                <img class="icons" src="PNGimage/github_red.png" alt="my GitHub">
            </a>
            <a href="https://www.linkedin.com/in/waseem-hemat-ghadari-518747372/">
                <img class="icons" src="PNGimage/linkedin_red.png" alt="my Linkedin">
            </a>
        </div>
        <p>Updated on 4 May 2026</p>
    </footer>
</body>
</html>

<?php
// Cleared after having been used
if ($preview) {
    unset($_SESSION['preview']);
}
?>