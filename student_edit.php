<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    if (!isset($_GET['id'])) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    $id = intval($_GET['id']);
    $student = $db->executeQuery("select * from `user` where id={$id}");
    if (!$student) {
        exit;
    }
    $student = $student[0];
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) &&
        isset($_POST['groupid'])) {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = (isset($_POST['password']) && $_POST['password'] != '') ? md5(trim($_POST['password'])) : $student['password'];
        $groupid = intval($_POST['groupid']);
        if ($firstname != '' && $lastname != '' && $email != '' && $password != '' && $groupid != 0) {
            if ($db->executeNonQuery("
                update `user`
                set firstname='{$firstname}',lastname='{$lastname}',email='{$email}',`password`='{$password}',groupid={$groupid}
                where id={$id}
            ")) {
                header('Location:student.php');
                exit;
            }
        }        
    }
    $groups = $db->executeQuery("select * from `group`");
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="content-fluid">
        <div class="span12">
            <h3>Create</h3>
            <form action="" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputFirstname">First Name</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $student['firstname']; ?>" name="firstname" id="inputFirstname" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputlastname">Last Name</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $student['lastname']; ?>" name="lastname" id="inputLastname" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $student['email']; ?>" name="email" id="inputEmail" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Password</label>
                    <div class="controls">
                        <input type="password" name="password" id="inputPassword" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputGroup">Group</label>
                    <div class="controls">
                        <select id="inputGroup" name="groupid">
                            <option value="0">-- select --</option>
                            <?php foreach ($groups as $group) { ?>
                            <option<?php if ($student['groupid'] == $group['id']) { ?> selected="selected"<?php } ?> value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
            <p>
                <a href="student.php">Back to List</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
