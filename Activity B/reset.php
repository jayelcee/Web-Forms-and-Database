<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Create a database connection
$mysqli = new mysqli("localhost", "root", "", "technical3_db");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve user information from the database
$username = $_SESSION['username'];
$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id, $password);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Convert the current password to SHA-2 encryption
    $currentPassword = hash("sha256", $currentPassword);

    if ($currentPassword != $password) {
        $error = "Current password is not the same as the old password";
    } elseif ($newPassword != $confirmPassword) {
        $error = "New password and Re-Enter new password should be the same";
    } else {
        // Convert the new password to SHA-2 encryption
        $newPassword = hash("sha256", $newPassword);

        // Update the password in the database
        $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $newPassword, $username);
        $stmt->execute();
        $stmt->close();

        // Redirect to the welcome page
        header("Location: welcome.php");
        exit();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Calibri, sans-serif;
            font-size: 14px;
        }
        .container {
            display: flex;
            flex-direction: column;
            text-align: left;
            background-color: #f2f2f2;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
            max-width: 500px;
            width: 100%;
        }
        .textbox {
            padding: 10px;
			border-radius: 5px;
			border: none;
			margin-bottom: 15px;
			width: 100%;
			box-sizing: border-box;
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: #ffa500;
        }
        h3 {
            text-align: center;
            margin: 5px;
        }
        p {
            text-align: left;
            margin-bottom: 0px;
            margin-top: 5px;
            margin-left: 10px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        button {
            background-color: #FFA836;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <br><br>
    <img src="panda.png" alt="Panda" width="200" height="100">
    <div class="container">
        <br>
        <h2>Reset Password</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p><b>Current Password:</b></p>
            <input type="password" name="current_password" class="textbox" required>
            <p><b>New Password:</b></p>
            <input type="password" name="new_password" class="textbox" required>
            <p><b>Re-Enter New Password:</b></p>
            <input type="password" name="confirm_password" class="textbox" required>
            <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>
            <button type="submit">Reset</button>
            <a href="welcome.php"><button type="button">Cancel</button></a>
        </form> <br>
    </div>
</body>
</html>
