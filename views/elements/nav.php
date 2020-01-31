<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/"><?=APP_NAME?></a>

    <?php
    // if user is logged in (session is NOT empty)
    if( !empty( $_SESSION['user_logged_in'] ) ) {
    ?>

    <form class="form-inline" id="search_form">
        <input type="search" autocomplete="off" name="search" id="search" class="form-control" placeholder="Search...">
        <div id="search_results">

        </div>
    </form>

    <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNavBar">
        <i class="fas fa-hamburger"></i>
    </button>
    <div class="navbar-collapse collapse" id="mainNavBar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="accountDropdown" data-toggle="dropdown">Welcome <?=$current_user['firstname']?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/users/">My Profile</a>
                    <a class="dropdown-item" href="/users/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
     <?php
    }
    ?>
</nav>