<?php
    include 'auth.php';
    unset($_SESSION['id']);
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);
    unset($_SESSION['groupid']);
    unset($_SESSION['role']);
    header('Location:signin.php');
    exit;