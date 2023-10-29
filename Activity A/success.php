<?php
session_start();

// Redirect to login page if user_info is not set
if (!isset($_SESSION['user_info'])) {
    header('Location: index.php');
    exit();
}

// Retrieve user information from the session
$user_info = $_SESSION['user_info'];

// Clear user_info from session
unset($_SESSION['user_info']);
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
            max-width: 350px;
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
        <p><strong>Full Name:</strong> <?php echo $user_info['full_name']; ?></p>
        <p><strong>Username:</strong> <?php echo $user_info['username']; ?></p>
        <p><strong>Password:</strong> <?php echo $user_info['password']; ?></p>
        <p><strong>Birthdate:</strong> <?php echo $user_info['birthdate']; ?></p>
        <p><strong>Email:</strong> <?php echo $user_info['email']; ?></p>
        <p><strong>Mobile Number: </strong> <?php echo "+63" . $user_info['mobile_number']; ?></p>
        

        <br><p>Login to your account <a href="index.php">here</a></p><br>
    </div>
</body>
</html>