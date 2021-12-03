<div class="nav-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark minw-500">
        <div class="container-fluid nav-max">
            <div class="company-logo col">
                <img src="../images/Logo1.png" alt="SITE LOGO"
                    title="Home"/>
            </div>
            <div class="">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse col-md" id="navbarTogglerDemo02">
                <?php
                if (!isset($_SESSION["staffId"])) {
                echo '
                <ul class="navbar-nav mt-lg-0 navbar-col-1">
                    <li class="nav-item">
                        <a class="nav-link bi bi-person-circle" href="instant_staff_login.php"> Login Direct for Professors Viewing</a>
                    </li>
                </ul>
                ';
                echo '
                <ul class="navbar-nav mt-lg-0 navbar-col-1">
                    <li class="nav-item">
                        <a class="nav-link bi bi-person-circle" href="../login.php"> Customer Login</a>
                    </li>
                </ul>
                ';
                }
                ?>
                <ul class="navbar-nav mt-lg-0 navbar-col-2">
                    <?php
                    if (isset($_SESSION["staffId"])) {
                        echo '
                        <li class="nav-item">
                            <a class="nav-link bi bi-box-arrow-in-right" href="staff_logout.php"> Logout</a>
                        </li>
                        ';
                    } else {echo'
                        <li class="nav-item">
                            <a class="nav-link bi bi-box-arrow-in-right" href="staff_login.php"> Staff Sign-in</a>
                        </li>
                        ';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
