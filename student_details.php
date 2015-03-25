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
    $groups = $db->executeQuery("select * from `group`");
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="content-fluid">
        <div class="span12">
            <h3>Details</h3>
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">First Name</label>
                    <div class="controls">
                        <?php echo $student['firstname']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Last Name</label>
                    <div class="controls">
                        <?php echo $student['lastname']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <?php echo $student['email']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Group</label>
                    <div class="controls">
                        <?php foreach ($groups as $group) { ?>
                        <?php if ($student['groupid'] == $group['id']) { echo $group['name']; } ?>
                        <?php } ?>
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
