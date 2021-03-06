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
        <div class="index-title-box minw-500">
            <div class="container">
                <header>
                    <h1 class="index-message">Welcome to Double'O4 Banking</h1>
                </header>
            </div>
        </div>
        <div class="index-page-content minw-500">
            <div class="container-fluid">
                <div class="card-box">
                    <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                        <div class="container">
                            <h1 class="display-4">Our Services</h1>
                        </div>
                    </div>
                    <div class="row card-list">
                        <a class="card index-card" href="personal_accounts.php">
                            <div class="card-body">
                                <p class="card-title h5">Create a bank account</p>
                                <p class="card-text">Find out about how we can help you save and grow your money.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="personal_loans.php">
                            <div class="card-body">
                                <p class="card-title h5">Apply for Loan</p>
                                <p class="card-text">Take a loan to finance your studies, your new flat, or your new car.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="personal_cards.php">
                            <div class="card-body">
                                <p class="card-title h5">Credit Cards</p>
                                <p class="card-text">We offer credit card services for our customers. Find out more here.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="banking_with_us.php">
                            <div class="card-body">
                                <p class="card-title h5">Bank with Us</p>
                                <p class="card-text">Check out the services that we are offering.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="finance.php">
                            <div class="card-body">
                                <p class="card-title h5">Business Financing</p>
                                <p class="card-text">Own a business? Read more about our banking services for business owners.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="trade_service.php">
                            <div class="card-body">
                                <p class="card-title h5">Trade Services</p>
                                <p class="card-text">We deliver comprehensive solutions to companies engaged in international and
                                    domestic trade transactions.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="faq.php">
                            <div class="card-body">
                                <p class="card-title h5">Frequently Asked Questions</p>
                                <p class="card-text">View some commonly asked questions here.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="privacy.php">
                            <div class="card-body">
                                <p class="card-title h5">Privacy Policy</p>
                                <p class="card-text">View our privacy policy.</p>
                            </div>
                        </a>
                        <a class="card index-card" href="t_and_c.php">
                            <div class="card-body">
                                <p class="card-title h5">Terms and Conditions</p>
                                <p class="card-text">View our terms and conditions.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>