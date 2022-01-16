<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="MainPage.css">
    <link rel="stylesheet" href="Common/style.css">

    <?php require_once "Common/Connection.php" ?>
    <?php require_once "Common/Sanitize.php" ?>


    <?php

    //    ---------------Signup-----------------
    //    Create Users
    function createUser($user_name, $email, $password)
    {
        global $tbl_users, $connect;
        $user_name = sanitize($user_name);
        $email = sanitize($email);
        $password = sanitize($password);

        $check_sql = "SELECT `id` FROM $tbl_users WHERE `user_name`=?";
        $result_sql = $connect->prepare($check_sql);
        $result_sql->bindValue(1, $user_name);
        $result_sql->execute();

        if ($result_sql->rowCount()) {
            return false;
        } else {
            $sql = "INSERT INTO `$tbl_users` SET `user_name`=? ,  `email`=? ,  `password`=?  ";
            $result = $connect->prepare($sql);
            $result->bindValue(1, $user_name);
            $result->bindValue(2, $email);
            $result->bindValue(3, sha1($password));
            $result->execute();
            return true;
        }

    }

    //    Check Button And Empty
    if (isset($_POST['signup'])) {
        if (!empty($_POST['signup_username']) && !empty($_POST['signup_email']) && !empty($_POST['signup_password'])) {
            $creation = createUser($_POST['signup_username'], $_POST['signup_email'], $_POST['signup_password']);
            if ($creation) {
                echo "<p style='position: absolute; top: 20px;color: forestgreen' >Account <strong>Created</strong></p>";
            } else {
                echo "<p style='position: absolute; top: 20px;color: red' >Account is already<strong> Registered</strong></p>";
            }
        }
    }


    //    ---------------Login-----------------
    function doLogin($user_name, $password)
    {
        global $tbl_users, $connect , $tbl_log;
        $user_name = sanitize($user_name);
        $password = sanitize($password);
        $password = sha1($password);
        $sql = ("SELECT `id` , `user_name` , `password` , `role` , `status` FROM $tbl_users WHERE `user_name` = ? AND `password` = ?");
        $result = $connect->prepare($sql);
        $result->bindValue(1, $user_name);
        $result->bindValue(2, $password);
        $result->execute();
        $row = $result->fetch();
        if ($result->rowCount()) {
            $login_sql = "INSERT INTO `$tbl_log` SET  `userId`=?, `status`=? ";
            $send_log = $connect->prepare($login_sql);
            $send_log->bindValue(1 , $row["id"]);
            $send_log->bindValue(2 , 2);
            $send_log->execute();
            return $row;
        } else {
            return false;
        }
    }

    //    Click Login
    if (isset($_POST['login'])) {
        $loginResult = doLogin($_POST['login_username'], $_POST['login_password']);
        if ($loginResult) {
            if ($loginResult['status'] == 1) {
                $_SESSION['key'] = "true";
                $_SESSION['id'] = $loginResult['id'];

                $hashed = md5($loginResult['user_name']);
                $_SESSION['hashed'] = md5($loginResult['user_name']);

                $_SESSION['user_name'] = $loginResult['user_name'];
                $_SESSION['password'] = $loginResult['password'];
                header("location: ./dashboard.php?verify=$hashed");

            } else if ($loginResult['status'] == 2) {
                echo "<p style='position: absolute; top: 20px;color: orange'>Your Account is <strong>not Active</strong>, Please Contact Support</p>";
            } else if ($loginResult['status'] == 3) {
                echo "<p style='position: absolute; top: 20px;color: red'>Your Account is <strong>Banned</strong>, Please Contact Support</p>";
            } else if ($loginResult['status'] == 4) {
                echo "<p style='position: absolute; top: 20px;color: Black'>Your Account is <strong>Suspend</strong></p>";
            }
        } else {
            echo "<p style='position: absolute; top: 20px;color: red'><strong>User</strong> does not <strong>Exist</strong></p>";
        }
    }


    ?>

</head>
<body>
<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
        <form method="post">
            <label for="chk" aria-hidden="true">Sign up</label>
            <input type="text" name="signup_username" placeholder="Username">
            <input type="email" name="signup_email" placeholder="Email">
            <input type="password" name="signup_password" placeholder="Password">
            <button type="submit" name="signup" id="signup">Sign up</button>
        </form>
    </div>

    <div class="login">
        <form method="post">
            <label id="login-true" for="chk" aria-hidden="true">Login</label>
            <input type="text" name="login_username" placeholder="Username">
            <input type="password" name="login_password" placeholder="Password">
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>