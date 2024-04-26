<?php
// Include necessary files
require "database.php";

// Check if the post ID is provided
if (!isset($_GET['postID'])) {
    // Redirect to view posts page if post ID is not provided
    header("Location: viewposts.php");
    exit;
}

// Fetch post details based on the provided post ID
$postID = $_GET['postID'];
$post = getPostByID($postID);

// Check if the post exists
if (!$post) {
    // Redirect to view posts page if post does not exist
    header("Location: viewposts.php");
    exit;
}

// Initialize error variable
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $comment = $_POST["comment"];

    // Add the comment to the database
    if (Comments($postID, $comment)) {
        // Redirect to view posts page after successful comment addition
        header("Location: viewposts.php?comment_added=true&postID=$postID");
        exit;
    } else {
        // Handle comment addition failure
        $error = "Failed to add comment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
    <!-- Your CSS styles here -->
</head>
<body>
    <div class="container">
        <h1>Add Comment</h1>
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['comment_added']) && $_GET['comment_added'] === "true"): ?>
            <p>Comment added successfully!</p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="comments">Comment:</label>
            <textarea id="comments" name="comment" required></textarea>
            <button type="submit">Add Comment</button>
        </form>
    </div>
</body>
</html>
