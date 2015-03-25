<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) &&
        isset($_POST['password']) && isset($_POST['groupid'])) {
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $groupid = intval($_POST['groupid']);
        if ($firstname != '' && $lastname != '' && $email != '' && $password != '' && $groupid != 0) {
            if ($db->executeNonQuery("
                insert into `user`(firstname,lastname,email,`password`,groupid)
                values('{$firstname}','{$lastname}','{$email}',md5('{$password}'),{$groupid})
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
                        <input type="text" name="firstname" id="inputFirstname" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputlastname">Last Name</label>
                    <div class="controls">
                        <input type="text" name="lastname" id="inputLastname" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="text" name="email" id="inputEmail" />
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
                            <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Create</button>
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
