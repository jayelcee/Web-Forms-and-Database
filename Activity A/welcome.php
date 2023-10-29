<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$user = null;
foreach ($_SESSION['user_list'] as $userItem) {
    if ($userItem['username'] === $_SESSION['username']) {
        $user = $userItem;
        break;
    }
}

function formatMobileNumber($number) {
    $formattedNumber = preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '+63-$1-$2-$3', $number);
    return $formattedNumber;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
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
        .textbox {
            display: inline-block;
            padding: 10px;
            background-color: white;
            color: black;
            border-radius: 5px;
            box-sizing: border-box;
            margin: 15px;
            margin-top: 0px;
            margin-bottom: 0px;
            line-height: auto;
        }
        .box {
            display: inline-block;
            padding: 0px;
            background-color: grey;
            color: white;
            border-radius: 5px;
            box-sizing: border-box;
            margin: 20px;
            line-height: auto;
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
        h4 {
            text-align: center;
            margin: 5px;
            font-weight: normal;
        }
        p {
            text-align: left;
            margin-bottom: 0px;
            margin-top: 5px;
            margin-left: 0px;
            text-indent: 25px;
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
        button[type="submit"]:hover {
            background-color: #FF8C00;
        }
    </style>
</head>
<body>
    <br><br>
    <img src="panda.png" alt="Panda" width="200" height="100">
    <div class="container">
        <br>
        <h2>Welcome, <?php echo $user['username']; ?>!</h2>

        <div class="box"><h3>User Profile</h3></div>
        <p><b>Full Name</b> <div class="textbox"><?php echo $user['full_name']; ?></div></p>
        <p><b>Username</b> <div class="textbox"><?php echo $user['username']; ?></div></p>
        <p><b>Password</b>
            <div class="textbox"><?php
                $password = $user['password'];
                $hiddenPassword = str_repeat('*', strlen($password));
                echo $hiddenPassword;
            ?></div>
        </p>
        <p><b>Birthdate</b> <div class="textbox"><?php echo $user['birthdate']; ?></div></p>
        <p><b>Email</b> <div class="textbox"><?php echo $user['email']; ?></div></p>
        <p><b>Mobile Number</b> <div class="textbox"><?php echo formatMobileNumber($user['mobile_number']); ?></div></p><br>

        <br><a href="logout.php"><button>Logout</button></a><br>
        <h4>Access another account? <a href="index.php">Switch</a></h4><br>
    </div>
</body>
</html>
