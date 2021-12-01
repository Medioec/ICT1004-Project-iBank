<div class="nav-wrapper">
    <nav class="navbar navbar-dark navbar-expand-lg minw-500">
        <div class="container-fluid nav-max">
            <div class="company-logo col">
                <img src="images/Logo1.png" alt="SITE LOGO"
                    title="Home"/>
            </div>
            <div class="">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse col-md" id="navbarTogglerDemo02">
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
                        Personal
                        </a>
                        <div class="dropdown-menu" aria-labelledby="personalBankingList">
                            <a class="dropdown-item" href="personal_accounts.php">Accounts</a>
                            <a class="dropdown-item" href="personal_loans.php">Loans</a>
                            <a class="dropdown-item" href="personal_cards.php">Cards</a>
                        </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="businessBankingList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Business
                            </a>
                            <div class="dropdown-menu" aria-labelledby="businessBankingList">
                            <a class="dropdown-item" href="banking_with_us.php">Banking with us</a>
                            <a class="dropdown-item" href="finance.php">Financing</a>
                            <a class="dropdown-item" href="trade_service.php">Trade Services</a>
                            </div>
                        </li>
                        ';
                    } else {
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountsLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Accounts
                            </a>
                            <div class="dropdown-menu" aria-labelledby="accountsLink">
                            <a class="dropdown-item" href="accounts_view.php">View Accounts</a>
                            <a class="dropdown-item" href="accounts_create.php">Create Account</a>
                            </div>
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
                    <?php
                    if (!isset($_SESSION["customerId"])) {
                        echo'
                        <li class="nav-item">
                            <a class="nav-link bi bi-box-arrow-in-right" href="login.php"> Sign-in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bi bi-person-circle" href="registration.php"> Sign-up</a>
                        </li>
                        ';
                    } else {
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="overflow-wrap: break-word;">
                                <p class="nav-link">Welcome, '.$_SESSION["displayName"].'</p>
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
        </div>
    </nav>
</div>
