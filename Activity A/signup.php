<?php
session_start();

// Initialize user_list
if (!isset($_SESSION['user_list'])) {
    $_SESSION['user_list'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birthdate = $_POST['birthdate'];

    // Validate input fields
    $errors = [];

    if (empty($last_name) || empty($first_name) || empty($middle_name)) {
        $errors[] = 'Full Name is required';
    }

    if (empty($email)) {
        $errors[] = 'Email Address is required';
    }

    if (empty($mobile_number)) {
        $errors[] = 'Mobile Number is required';
    }

    if (empty($username)) {
        $errors[] = 'Username is required';
    } elseif (strlen($username) < 5) {
        $errors[] = 'Username must be at least 5 characters';
    } elseif (in_array($username, $_SESSION['user_list'])) {
        $errors[] = 'Username already exists';
    }

    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&-])[A-Za-z\d@$!%*#?&-]{8,}$/', $password)) {
        $errors[] = 'Password must contain at least one letter, one number, and one special character';
    }

    if (empty($confirm_password)) {
        $errors[] = 'Confirm Password is required';
    } elseif ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match!';
    }

    if (empty($errors)) {
        // Concatenate Full Name
        $full_name = $first_name . ' ' . $middle_name . ' ' . $last_name;

        // Save user info to user_list
        $_SESSION['user_list'][] = [
            'full_name' => $full_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'username' => $username,
            'password' => $password,
            'birthdate' => $birthdate,
            'email' => $email,
            'mobile_number' => $mobile_number
        ];

        // Store user information in a variable
        $user_info = [
            'full_name' => $full_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'username' => $username,
            'password' => $password,
            'birthdate' => $birthdate,
            'email' => $email,
            'mobile_number' => $mobile_number
        ];

        // Store the user information in a session variable
        $_SESSION['user_info'] = $user_info;

        // Redirect to success page
        header('Location: success.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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
            margin-left: 7px;
			font-weight: bold;
		}
        .container {
            text-align: center;
        }
        p {
			text-align: center;
		}
        h2 {
			text-align: center;
            color: #ffa500;
		}
        h4 {
			text-align: left;
            font-family: Calibri, sans-serif;
			font-size: 14px;
            font-weight: normal;
            margin-top: -10px;
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
		input[type="email"],
        input[type="date"],
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

        .input-container {
            position: relative;
        }

        .input-container input[type="text"] {
            padding-left: 40px;
        }

        .input-container::before {
            content: "+63";
            position: absolute;
            left: 10px;
            bottom: 10px;
            top: 10;
            transform: translateY(-80%);
            font-weight: bold;
            color: #999;
        }

    </style>
</head>
<body>
<div class="container">
    <br><br>
    <img src="panda.png" alt="Panda" width="200" height="100">
    <form method="post" action="">
        <h2>My Personal Information</h2>
        <label for="full_name">Full Name:</label>
        <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
        <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" required>
        <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="create username" minlength="5" required>
        <h4>&nbsp;&nbsp;Must be at least 5 characters long.</h4>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="create password" minlength="8" required>
        <h4>&nbsp;&nbsp;Must be at least 8 characters with alphanumeric and special characters.</h4>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="enter password again for confirmation" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required>


        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="email@gmail.com.ph" required>

        <label for="mobile_number">Mobile Number:</label>
        <div class="input-container">
            <input type="text" id="mobile_number" name="mobile_number" placeholder="enter 10 numbers" pattern="[0-9]{10}" required>
        </div>

        <?php if (!empty($errors)) { ?>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <input type="submit" value="Register">
        <p>Already have an account? <a href="index.php">Login</a></p>
    </form><br><br>
</div>
</body>
</html>
