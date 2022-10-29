<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark  fixed-top">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home_Admin')?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a class="nav-link" href="categories.php"><?php echo lang('Cat')?></a>    
                <a class="nav-link" href="#"><?php echo lang('items')?></a>
                <a class="nav-link" href="member.php"><?php echo lang('memebers')?></a>
                <a class="nav-link" href="#"><?php echo lang('statis')?></a>
                <a class="nav-link" href="#"><?php echo lang('logs')?></a>
            </ul>
            <ul class="navbar-nav active">
                <li class="nav-item dropdown ">
                   
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" > Abdullah </a>
                   
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="member.php?do=Edit&userid=<?php echo $_SESSION['ID']?>">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="#">Setings</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>