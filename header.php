<?php
$current_page =  pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
// echo $current_page;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- <a class="navbar-brand" href="#">Navbar</a> -->
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 float-right">
                <li class="nav-item  <?php if($current_page == 'dashboard') echo 'active'?>">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item <?php if($current_page == 'category_listing') echo 'active'?>">
                <a class="nav-link" href="category_listing.php" >Categories</a>
                </li>
                <li class="nav-item dropdown float-right">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <!-- <a class="dropdown-item" href="#">profile</a> -->
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>