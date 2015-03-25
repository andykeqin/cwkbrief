<?php
    include 'auth.php';
    include 'db.php';
    $db = new DbHelper();
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    if ($search == '') {
        $reports = $db->executeQuery("
            select a.*,b.name as `group`,c.firstname,c.lastname
            from report a,`group` b,`user` c
            where a.groupid=b.id and a.authorid=c.id
            order by a.createtime desc
        ");
    }
    else {
        $reports = $db->executeQuery("
            select a.*,b.name as `group`,c.firstname,c.lastname
            from report a,`group` b,`user` c
            where a.groupid=b.id and a.authorid=c.id and a.name like '%{$search}%'
            order by a.createtime desc
        ");
    }
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3>Report</h3>
            <p>
                <a href="report_create.php">Create New</a>
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
                        <th>Name</th>
                        <th>Author</th>
                        <th>Group</th>
                        <th>Create Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) { ?>
                    <tr>
                        <td><?php echo $report['name']; ?></td>
                        <td><?php echo $report['firstname'] . ' ' . $report['lastname']; ?></td>
                        <td><?php echo $report['group']; ?></td>
                        <td><?php echo date('Y-m-d H:i', $report['createtime']); ?></td>
                        <td>
                            <a href="report_details.php?id=<?php echo $report['id']; ?>">Details</a><?php if ($report['authorid'] == $_SESSION['id']) { ?> | <a href="javascript:if(confirm('Delete?'))location.href='report_delete.php?id=<?php echo $report['id']; ?>';">Delete</a><?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>