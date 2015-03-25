<?php
    include 'auth.php';
    if (isset($_POST['name']) && isset($_FILES['file'])) {
        $name = trim($_POST['name']);
        $file = $_FILES['file'];
        if ($name != '' && $file['error'] == 0) {
            if ($file['type'] == 'text/plain') {
                $dir = 'uploads/';
                $dir .= date('Y');
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
                $dir .= '/' . date('m');
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
                $dir .= '/' . date('d');
                if (!is_dir($dir)) {
                    mkdir($dir);
                }
                $filepath = $dir . '/' . md5(time() . rand()) . '.txt';
                move_uploaded_file($file['tmp_name'], $filepath);
                include 'db.php';
                $db = new DbHelper();
                $createtime = time();
                if ($db->executeNonQuery("
                    INSERT INTO report(groupid,name,url,createtime,authorid)
                    VALUES({$_SESSION['groupid']},'{$name}','{$filepath}',{$createtime},{$_SESSION['id']})
                ")) {
                    header('Location:report.php');
                    exit;
                }
            }
        }
    }
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3>Create</h3>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="control-group">
                    <label class="control-label" for="inputName">Name</label>
                    <div class="controls">
                        <input type="text" name="name" id="inputName" placeholder="Name" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputFile">File</label>
                    <div class="controls">
                        <input type="file" name="file" id="inputName" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
            <p>
                <a href="report.php">Back to List</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>