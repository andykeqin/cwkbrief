<?php
    include 'auth.php';
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        include 'db.php';
        $db = new DbHelper();
        $report = $db->executeQuery("
            select * from report where id={$id} and groupid={$_SESSION['groupid']} and authorid={$_SESSION['id']}
        ");
        if ($report && count($report) > 0) {
            $report = $report[0];
            unlink($report['url']);
            if ($db->executeNonQuery("delete from report where id={$id}")) {
                header('Location:report.php');
                exit;
            }
        }
    }