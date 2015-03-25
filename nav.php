<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="">Cwk Brief</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    Logged in as <a href="logout.php" class="navbar-link"><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></a>
                </p>
                <!--<ul class="nav">
                    <li class="active">
                        <a href="">Group</a>
                    </li>
                </ul>-->
            </div>
        </div>
    </div>
</div>