<?php
    header('Content-Type:text/html;charset=utf-8');
    session_start();
    if (!isset($_SESSION['id'])) {
        header('Location:signin.php');
        exit;
    }