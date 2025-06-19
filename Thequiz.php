<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "divine";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $conn->real_escape_string($_POST['username'] ?? '');
    $pass = $conn->real_escape_string($_POST['password'] ?? '');

    $sql = "SELECT * FROM users WHERE Username = '$user' AND Password = '$pass'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $message = "Welcome, $user!";
        $type = "success";
    } else {
        $message = "Invalid username or password.";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Logo" />
        </div>
        <?php if (!empty($message)): ?>
            <div class="popup <?= $type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form action="Thequiz.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Enter username" required />
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Enter password" required />
            </div>

            <button type="submit">LOGIN</button>
            <a href="#" class="forgot">Forgot password?</a>
        </form>
    </div>
    <div id="popup" class="popup" style="display:none;"></div>
</body>

</html>