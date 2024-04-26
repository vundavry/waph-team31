<?php
session_start();
    // Check if user is authenticated
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: form.php");
    exit;
}

// Include necessary files
require "database.php";

// Fetch username of the current user
$username = $_SESSION['username'];

// Fetch posts for the current user
$posts = getAllPosts();
// Check if delete button is clicked
if (isset($_GET['postID'])) {
    $deleteID = $_GET['postID'];
    deletePostByID($postID);
    // Redirect back to viewposts.php after deleting the post
    header("Location: viewposts.php");
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Posts</title>
    
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f2f2f2;
}

a {
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    color: #1877f2;
    border: 1px solid #1877f2;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

a:hover {
    background-color: #1877f2;
    color: #ffffff;
}
</style>
</head>
<body>
<div class="container">
    <h1>View Posts</h1>

    <?php if ($posts): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Post Time</th>
                    <th>Owner</th>
                    <th>Actions</th> <!-- New column for actions -->
                    <th>comments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['content']; ?></td>
                        <td><?php echo $post['posttime']; ?></td>
                        <td><?php echo $post['owner']; ?></td>
                        <td>
                            <!-- Edit button -->

                            <a href="edit.php?postID=<?php echo $post['postID']; ?>">Edit</a>

                            <!-- Delete button (you can use JavaScript to confirm deletion) -->
                            <a href="delete.php?postID=<?php echo $post['postID']; ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>

                            <!-- Add comment button -->
                            <a href="comments.php?postID=<?php echo $post['postID']; ?>">Add Comment</a>
                        </td>
                        <td>

<?php
global $mysqli;
    $prepared_sql = "SELECT * FROM comments WHERE postID = ?";
    $stmt = $mysqli->prepare($prepared_sql);
    $stmt->bind_param("i", $post['postID']);  // Assuming postID is integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['comment'];
        }
    }
?>

                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>

    <a href="index.php">Back to Home</a>
</div>
</body>
</html>