<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include "head.inc.php";
?>

<body>
    <?php
    include "nav.inc.php";
    ?>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="banking_with_us.php">Banking with Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="finance.php">Financing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trade_service.php">Trade Services</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid info-main-content">
                <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">Asset Financing</h1>
                        <p class="lead">An Overview of the support that we can offer to your business</p>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <p class="lead">As a leading bank in Asia, our core strength lies in our
                            ability to combine our industry-specific knowledge and experience
                            to deliver innovative financial solutions to meet our customers’
                            changing needs. As you make your next capital expenditure to expand
                            your business or to enhance your business capabilities, we can provide
                            the suitable financial solution to achieve your business goals.
                        </p>
                        <p class="lead">At Double'O4 Corporate Banking, we understand that to expand your business
                            or to enhance your business capabilities, companies need to make capital
                            investments. Be it a purchase of equipment/ commercial vehicles or, buying
                            of new land/ property or renewing or building up your fleet of aircraft, our
                            dedicated team of Product Sales Specialists and Relationship Managers have
                            the expertise to help you efficiently acquire the fixed assets.
                        </p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="card-box">
                        <h2> Our Services: </h2><br><br>
                        <div class="row card-list" id="advancedAccordion">

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title1">Commercial & Industrial Property Loan</p>
                                    </div>
                                </a>
                                <div id="collapse1" class="collapse hover-collapse" aria-labelledby="title1" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Enjoy Attractive interest rates, Higher financing quantum & Flexible financing structure
                                            ( a combination of overdraft / term loan/ trade facilities is available)</p>
                                        <p>All businesses incorporated in Singapore are eligible to apply.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title2">Machinery / Equipment Financing</p>
                                    </div>
                                </a>
                                <div id="collapse2" class="collapse hover-collapse" aria-labelledby="title2" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Enjoy competitive interest rates & the choice of financing of either hire purchase facility or term loan.</p>
                                        <p>All businesses incorporated in Singapore are eligible to apply.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title3">SME HP Facility / Equipment & Factory Loan</p>
                                    </div>
                                </a>
                                <div id="collapse3" class="collapse hover-collapse" aria-labelledby="title3" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Administered by SPRING Singapore, Financing of up to $15million & Loan tenure of up to 8
                                            years for SME HP/ SME equipment loan & 10 years for SME factory loan.</p>
                                        <p>Company registered & operating in Singapore with at least 30% local shareholding & group^
                                            annual sales turnover of <=S$100m or group employment <=200 are eligible.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title4">Asset Based Financing Under IF Scheme</p>
                                    </div>
                                </a>
                                <div id="collapse4" class="collapse hover-collapse" aria-labelledby="title4" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Administered by IE Singapore, Financing purchase/ construction of factories / buildings / fixed assets
                                            (such as machinery/ equipment) for overseas use. We provide funding of up to S$30m (on group basis)
                                            and loan tenure of up to 6 years for fixed assets & 15 years for factories.</p>
                                        <p>Companies who are eligible must either be a Singapore-based company with meaningful business operations and
                                            at least 3 strategic business functions in Singapore. For non-trading companies, the turnover shall not
                                            exceed S$300 million. For trading companies, the turnover shall not exceed S$500 million.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title5">Aircraft Financing</p>
                                    </div>
                                </a>
                                <div id="collapse5" class="collapse hover-collapse" aria-labelledby="title5" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>We have flexible financing structure to finance the growth of your fleet, competitive interest rates and
                                            you can customized repayment terms which helps you to manage your cash flow.</p>
                                        <p>All businesses incorporated in Singapore are eligible to apply.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title6">Commercial Vehicle Financing</p>
                                    </div>
                                </a>
                                <div id="collapse6" class="collapse hover-collapse" aria-labelledby="title6" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>We provide High Financing quantum, hire Purchase financing available for commercial vehicle and commercial
                                            vehicle with renewed COE and obtaining ownership of the vehicle upon fulfilling payment of loan installment.</p>
                                        <p>All businesses incorporated in Singapore are eligible to apply.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    include "footer.inc.php";
    ?>
</body>

</html>
