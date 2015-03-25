<?php
    include 'auth.php';
    if (!isset($_GET['id'])) {
        exit;
    }
    $id = intval($_GET['id']);
    include 'db.php';
    $db = new DbHelper();
    $report = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname
        from report a,`group` b,`user` c
        where a.id={$id} and a.authorid=c.id and a.groupid=b.id
    ");
    if ($report && count($report) > 0) {
        $report = $report[0];
    }
    else {
        exit;
    }
    if (isset($_POST['assessment']) && isset($_POST['comment'])) {
        $assessment = intval($_POST['assessment']);
        $comment = $_POST['comment'];
        $createtime = time();
        if (!$db->executeNonQuery("
            insert into `comment`(userid,reportid,assessment,content,createtime)
            values({$_SESSION['id']},{$id},{$assessment},'{$comment}',{$createtime})
        ")) {
            exit;
        }
    }
    $comments = $db->executeQuery("
        select a.*,b.name as `group`,c.firstname,c.lastname 
        from `comment` a,`group` b,`user` c
        where a.reportid={$id} and b.id=c.groupid and a.userid=c.id
    ");
?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h3><?php echo $report['name']; ?></h3>
            <p>
                Author: <?php echo $report['firstname'] . ' ' . $report['lastname']; ?>
            </p>
            <p>
                Group: <?php echo $report['group']; ?>
            </p>
            <p>
                <?php readfile($report['url']); ?>
            </p>
            <h3>Assessments and comments</h3>
            <ul>
                <?php foreach ($comments as $c) { ?>
                <li><?php echo $c['firstname'] . ' ' . $c['lastname']; ?>(<?php echo $c['group']; ?>): <?php echo $c['content']; ?>(<?php echo $c['assessment']; ?>)</li>
                <?php } ?>
            </ul>
            <form action="" method="post">
                <p>
                    <label for="txt-assessment">assessment</label>
                    <input type="text" id="txt-assessment" name="assessment" />
                </p>
                <p>
                    <label for="txt-comment">comment</label>
                    <input type="text" id="txt-comment" name="comment" />
                </p>
                <p>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </p>
            </form>
            <p>
                <a href="report.php">Back to List</a>
            </p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>