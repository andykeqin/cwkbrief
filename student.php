<?php
    include 'auth.php';
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        exit;
    }
    include 'db.php';
    $db = new DbHelper();
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    if ($search == '') {
        $students = $db->executeQuery("
            select a.*,b.name as `group`
            from `user` a,`group` b
            where a.groupid=b.id and a.groupid is not null
        ");
    }
    else {
        $students = $db->executeQuery("
            select a.*,b.name as `group`
            from `user` a,`group` b
            where a.groupid=b.id and a.groupid is not null and (firstname like '%{$search}%' or lastname like '%{$search}%' or email like '%{$search}%')
        ");
    }
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="content-fluid">
        <div class="span12">
            <h3>Student</h3>
            <p>
                <a href="student_create.php">Create New</a>
            </p>
            <p>
                <form action="" method="get">
                    <input value="<?php echo $search; ?>" type="text" name="search" placeholder="Search" />
                    <button style="vertical-align: top;" type="submit" class="btn btn-primary">Search</button>
                </form>
            </p>
            <table class="table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Group</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?php echo $student['firstname']; ?></td>
                        <td><?php echo $student['lastname']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['group']; ?></td>
                        <td>
                            <a href="student_edit.php?id=<?php echo $student['id']; ?>">Edit</a> | <a href="student_details.php?id=<?php echo $student['id']; ?>">Details</a> | <a href="javascript:if(confirm('Delete?'))location.href='student_delete.php?id=<?php echo $student['id']; ?>';">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
