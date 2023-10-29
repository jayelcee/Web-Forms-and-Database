<?php
session_start();
require_once "config.php";

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit();
}

// Create a database connection
$mysqli = new mysqli("localhost", "root", "", "technical3_db");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and execute SQL query to fetch user from the database
    $stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_password);
    $stmt->fetch();
    $stmt->close();

    if ($db_username === $username && hash('sha256', $password) === $db_password) {
        $_SESSION['username'] = $username;

        if (isset($_POST['remember'])) {
            // Create cookies for username and password
            setcookie('username', $username, time() + 3600 * 24 * 7);
            setcookie('password', $password, time() + 3600 * 24 * 7);
        } else {
            // If "Remember me" checkbox is not selected, delete the existing cookies
            setcookie('username', '', time() - 3600);
            setcookie('password', '', time() - 3600);
        }

        header('Location: welcome.php');
        exit();
    } elseif ($db_username === $username && hash('sha256', $password) !== $db_password) {
        $error = 'Password is incorrect. Try again.';
    } else {
        $error = 'User does not exist. Sign up first.';
    }
} elseif (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    // If remember me cookies are set, automatically login user using the stored credentials
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];

    // Prepare and execute SQL query to fetch user from the database
    $stmt = $mysqli->prepare("SELECT username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_password);
    $stmt->fetch();
    $stmt->close();

    if ($db_username === $username && hash('sha256', $password) === $db_password) {
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
      form {
        display: flex;
        flex-direction: column;
        text-align: left;
        background-color: #f2f2f2;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px #ccc;
        max-width: 800px;
        width: 100%;
      }
      body {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-family: Calibri, sans-serif;
        font-size: 14px;
      }
      label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
      }
      .container {
        text-align: center;
      }
      p {
        text-align: center;
      }
      input[type="submit"] {
        background-color: #FFA836;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
      }
      input[type="text"],
      input[type="password"] {
        padding: 10px;
        border-radius: 5px;
        border: none;
        margin-bottom: 15px;
        width: 100%;
        box-sizing: border-box;
      }
		input[type="submit"]:hover{
			background-color: #FF8C00;
		}
    </style>
</head>
<body>
    <div class="container">
        <br><br>
        <img src="panda.png" alt="Panda" width="200" height="100">
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <?php if (isset($error)) { ?>
                <p><?php echo $error; ?></p>
            <?php } ?>

            <label for="remember">
                <input type="checkbox" id="remember" name="remember">
                Remember me 
            </label><br>

            <input type="submit" value="Login">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
  </div>
</body>
</html>
