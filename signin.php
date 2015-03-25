<?php
    header('Content-Type:text/html;charset=utf-8');
    session_start();
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        include 'db.php';
        $db = new DbHelper();
        $user = $db->executeQuery("SELECT * FROM `user` WHERE email='{$email}' AND `password`=MD5('{$password}')");
        if ($user && count($user) > 0) {
            $user = $user[0];
            $_SESSION['id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['groupid'] = $user['groupid'];
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 1) {
                header('Location:student.php');
            }
            else {
                header('Location:report.php');
            }
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <title>Sign in &middot; CwkBrief</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
        }
        body {
            /*padding-top: 40px;
            padding-bottom: 40px;*/
            background-color: #f5f5f5;
        }
        .form-signin {
            text-align: left;
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }
        .form-signin .form-signin-heading {
            margin-bottom: 10px;
        }
        .form-signin input[type="text"], .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }
        .tr {
            display: table;
            height: 100%;
            width: 100%;
            text-align: center;
        }
        .td {
            display: table-cell;
            vertical-align: middle;
            height: 100%;
        }
        .td > span {
            display: inline-block;
        }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
    <script src="scripts/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</head>
<body>
    <div class="tr">
        <div class="td">
            <span>
                <div class="container">
                    <form class="form-signin" action="" method="post">
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <input type="text" name="email" class="input-block-level" placeholder="Email address" />
                        <input type="password" name="password" class="input-block-level" placeholder="Password" />
                        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
                    </form>
                </div>
            </span>
        </div>
    </div>
</body>
</html>