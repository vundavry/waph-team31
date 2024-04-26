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

// Delete the post from the database
if (!deletePostByID($postID)) {
    // Redirect to view posts page after successful deletion
    header("Location: viewposts.php");
    exit;
} else {
    // Handle deletion failure
    echo "Failed to delete post.";
}
?>
