<!DOCTYPE html>
<html>
    <?php include "head.inc.php";?>
    <body>
        <?php include "nav.inc.php";?>
        <div class='page-bg'></div>
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
                    <h2> Our Services: </h2><br><br>
                        <div class="row card-list">
                            <a class="card index-card" href="personal_accounts.php">
                                <div class="card-body">
                                    <h5 class="card-title">Create a bank account</h5>
                                    <p class="card-text">Find out about how we can help you save and grow your money.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Apply for Loan</h5>
                                    <p class="card-text">Take a loan to finance your studies, your new flat, or your new car.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Credit Cards</h5>
                                    <p class="card-text">We offer credit card services for our customers. Find out more here.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Currency Exchange</h5>
                                    <p class="card-text">We offer attractive rates with low conversion fees for foreign currency exchange.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Invest</h5>
                                    <p class="card-text">Let us help you with securing the best investment opportunities.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Business Financing</h5>
                                    <p class="card-text">Own a business? Read more about our banking services for business owners.</p>
                                </div>
                            </a>
                            <a class="card index-card" href="">
                                <div class="card-body">
                                    <h5 class="card-title">Trade Services</h5>
                                    <p class="card-text">We deliver comprehensive solutions to companies engaged in international and
                                         domestic trade transactions.</p>
                                </div>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "footer.inc.php";?>
    </body>
</html>
