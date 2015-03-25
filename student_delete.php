<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    $id = intval($_GET['id']);
    $student = $db->executeQuery("select * from `user` where id={$id}");
    if (!$student) {
        exit;
    }
    if ($db->executeNonQuery("delete from `user` where id={$id}")) {
        header('Location:student.php');
        exit;
    }