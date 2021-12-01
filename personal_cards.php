<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class='page-bg'></div>
    <header>
        <div class="carousel-container">
            <div class="page_carousel">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel" data-slide-to="1"></li>
                        <li data-target="#carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/abstract.jpg" alt="Abstract slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/building.jpg" alt="Building slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/clients.jpg" alt="client slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main class="index-page-body minw-500">
        <div class="index-page-content minw-500">
            <div class="front-side-menu" id="jsMenu">
                <div class="side-menu-title">
                    <h3>Links</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="personal_accounts.php">Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="personal_loans.php">Loans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="personal_cards.php">Cards</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid info-main-content">
                <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">Apply for our credit cards now!</h1>
                        <p class="lead">Unlock a new world of possibilities</p>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <div class="row">
                            <h1 class="display-4 col-md-5">No Monthly Fees</h1>
                            <p class="lead col">No payment required to get your credit card. Not now, not ever!</p>
                        </div>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <div class="row">
                            <p class="lead col">We work with a large range of partners to make sure that you get to enjoy some of the best deals on the island.</p>
                            <h1 class="display-4 col-md-5">Fantastic Rebates</h1>
                        </div>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <div class="row">
                            <h1 class="display-4 col-md-5">Generous Rates</h1>
                            <p class="lead col">Our conversion and interest rates are among the fairest there is. We enable you to stretch your dollar to the fullest.</p>
                        </div>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">What are you waiting for?</h1>
                        <p class="lead col">Contact us to apply for a credit card now!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>