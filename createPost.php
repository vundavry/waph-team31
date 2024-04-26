<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: form.php");
    exit
}

// Include necessary files
require "database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $content = $_POST["content"];
    $posttime = date("Y-m-d H:i:s"); // Assuming posttime is a timestamp
    $owner = $_SESSION["username"]; // Get the username of the current user from session

    // Call createPost function to insert the post into the database
    if (createPost($title, $content, $posttime, $owner)) {
        // Post created successfully
        echo "Post created successfully!";
    } else {
        // Failed to create post
        echo "Failed to create post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>
    <h1>Create Post</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" required></textarea><br>
        <button type="submit">Create Post</button>
    </form>
    <br>
    <a href="index.php">Back to Home</a> <!-- Link to go back to home page -->
</body>
</html>
