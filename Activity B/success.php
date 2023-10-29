<?php
session_start();
require_once "config.php";

// Redirect to login page if user_info is not set
if (!isset($_SESSION['user_info'])) {
    header('Location: index.php');
    exit();
}

// Retrieve user information from the session
$user_info = $_SESSION['user_info'];

// Clear user_info from session
unset($_SESSION['user_info']);

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL query to fetch user information from the database
$stmt = $conn->prepare("SELECT first_name, middle_name, last_name, username, password, birthdate, email, mobile_number FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$username = $user_info['username'];
$stmt->execute();
$stmt->bind_result($first_name, $middle_name, $last_name, $username, $password, $birthdate, $email, $mobile_number);

// Fetch the results
$stmt->fetch();

// Close the statement and database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Successful Registration</title>
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
            max-width: 570px;
            width: 100%;
        }
        h3 {
            text-align: center;
            margin: 5px;
        }
        p {
            text-align: left;
            margin-bottom: 5px;
            margin-top: 5px;
            margin-left: 25px;
        }
        button {
            background-color: #FFA836;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            width: 91.5%;
            margin: 15px;
            margin-top: 0px;
            margin-bottom: 0px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <br><br>
    <img src="panda.png" alt="Panda" width="200" height="100">
    <div class="container">
        <h3>You have successfully created an account!</h3><br>
        <p><strong>Full Name:</strong> <?php echo $first_name . ' ' . $middle_name . ' ' . $last_name; ?></p>
        <p><strong>Username:</strong> <?php echo $username; ?></p>
        <p><strong>Password:</strong> <?php echo $password; ?></p>
        <p><strong>Birthdate:</strong> <?php echo $birthdate; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Mobile Number: </strong> <?php echo $mobile_number; ?></p>
        

        <br><p>Login to your account <a href="index.php">here</a></p><br>
    </div>
</body>
</html>