<div class="nav-wrapper">
    <nav class="navbar navbar-expand-md navbar-dark minw-500">
        <a class="company-logo" href="">
            <img src="images/Logo1.png" alt="SITE LOGO"
                 title="Home"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mt-lg-0 navbar-col-1">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <?php if (!isset($_SESSION["customerId"])) {
                    echo'
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="personalBankingList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Personal Banking
                    </a>
                    <div class="dropdown-menu" aria-labelledby="personalBankingList">
                        <a class="dropdown-item" href="">Accounts</a>
                        <a class="dropdown-item" href="">Loans</a>
                        <a class="dropdown-item" href="">Cards</a>
                    </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="businessBankingList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Business Banking
                        </a>
                        <div class="dropdown-menu" aria-labelledby="businessBankingList">
                        <a class="dropdown-item" href="">Products</a>
                        <a class="dropdown-item" href="">Financing</a>
                        <a class="dropdown-item" href="">Corporate</a>
                        </div>
                    </li>
                    ';
                } else {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="accounts_view.php">Accounts</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="transferLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Transfer
                        </a>
                        <div class="dropdown-menu" aria-labelledby="transferLink">
                        <a class="dropdown-item" href="transfer_to_own.php">To own account</a>
                        <a class="dropdown-item" href="transfer_to_other.php">To other account</a>
                        <a class="dropdown-item" href="view_transaction.php">View history</a>
                        </div>
                    </li>
                    ';
                }
                ?>
            </ul>
            <ul class="navbar-nav mt-lg-0 navbar-col-2">
                <?php if (!isset($_SESSION["customerId"])) {
                    echo'
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sign-in</a>
                    </li>
                    ';
                } else {
                    echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome, '.$_SESSION["displayName"].'
                        </a>
                        <div class="dropdown-menu" aria-labelledby="accountList">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <a class="dropdown-item" href="update_profile.php">Update Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>