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
            <div class="front-side-menu">
                <div class="side-menu-title">
                    <h3>Links</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link active" href="banking_with_us.php">Banking with Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="finance.php">Financing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trade_service.php">Trade Services</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid info-main-content">
                <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">Bank with Double'O4</h1>
                        <p class="lead">Run your business efficiently with our
                            24/7 digital banking, islandwide branches, and dedicated SME resources.</p>
                    </div>
                </div>
                <div class="row justify-content-sm-center">
                    <section class="bwu_section">
                        <div class="card big-card">
                            <img class="card-img-top" src="images/onlinebanking.jpg" alt="Internet Banking">
                            <div class="card-body">
                                <p class="card-title h5">Business Internet Banking</h5>
                                <p class="card-text">The digital banking platform for businesses that's fast, secure, and easy to use.</p>
                                <a href="#" class="btn btn-primary">Internet Banking</a>
                            </div>
                        </div>
                    </section>
                    <section class="bwu_section">
                        <div class="card big-card">
                            <img class="card-img-top" src="images/tradecounters.jpg" alt="Trade Counters">
                            <div class="card-body">
                                <p class="card-title h5">Trade Counters</h5>
                                <p class="card-text">Collect trade documents or submit forms at dedicated counters islandwide.</p>
                                <a href="#" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </section>
                    <section class="bwu_section">
                        <div class="card big-card">
                            <img class="card-img-top" src="images/atm.jpg" alt="ATMs & Branches">
                            <div class="card-body">
                                <p class="card-title h5">ATMs & Branches</h5>
                                <p class="card-text">Visit your nearest Double'O4 branch or any of our self-service machines and ATMs.</p>
                                <a href="#" class="btn btn-primary">Find Us</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>