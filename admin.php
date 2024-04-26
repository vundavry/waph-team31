<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <?php
    session_start();
    // Check if admin is logged in
    if (!isset($_SESSION['admin'])) {
        header("Location: superform.php");
        exit();
    }
    ?>
    <h1 class="text-center">Welcome, <?php echo $_SESSION['admin']; ?></h1>
    <a href="superform.php" class="btn btn-danger float-right">Logout</a>

    <div class="row mt-4">
        <?php
        $lifetime = 15 * 60;
        $path = "/";
        $domain = "waph-team31.minifacebook.com";
        $secure = TRUE;
        $httponly = TRUE;
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
        session_start();
        $mysqli = new mysqli('localhost', 'waph-team31','Pa$$w0rd', 'waph_team');
        if ($mysqli->connect_errno) {
            printf("DB connection failed", $mysqli->connect_error);
            exit();
        }
        $allusers = [];
        $sql = "SELECT * FROM users";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $allusers[] = $row;
                ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['username']; ?></h5>
                            <p class="card-text">Email: <?php echo $row['additional_email']; ?></p>
                            <p class="card-text">Phone: <?php echo $row['phone']; ?></p>
                            <form action="useraccess.php" method="POST">
                                <input type="hidden" name="username"
                                       value="<?php echo $row['username']; ?>">
                                <input type="hidden" name="status"
                                       value="<?php echo $row['status']; ?>">
                                <button type="button" name="toggle" class="btn <?php echo ($row['status'] === 'enable') ? 'btn-success' : 'btn-danger'; ?>">
                                    <?php echo ($row['status'] === 'enable') ? 'enabled' : 'disabled'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<script>
    // Add event listeners to toggle buttons
    const buttons = document.querySelectorAll('button[name="toggle"]');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const username = button.form.querySelector('input[name="username"]').value;
            const statusInput = button.form.querySelector('input[name="status"]');
            const status = statusInput.value;

            // Toggle status and button color
            if (status === 'enable') {
                statusInput.value = 'disable';
                button.textContent = 'Disabled';
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
            } else {
                statusInput.value = 'enable';
                button.textContent = 'Enabled';
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
            }

            // Send AJAX request to update user status
            const formData = new FormData();
            formData.append('username', username);
            formData.append('status', statusInput.value);

            fetch('useraccess.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    console.error('Failed to update user status');
                }
                else{
                    alert("Account Status Updated !");
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>

</body>
</html>
