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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $title = $_POST["title"];
    $content = $_POST["content"];

    // Update the post in the database
    if (!updatePostByID($postID, $title, $content)) {
        // Redirect to view posts page after successful update
        header("Location: viewposts.php");
        exit;
    } else {
        // Handle update failure
        echo "Failed to update post.";
    }
}
?>

