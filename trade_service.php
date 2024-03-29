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
                    <li class="nav-item">
                        <a class="nav-link" href="banking_with_us.php">Banking with Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="finance.php">Financing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="trade_service.php">Trade Services</a>
                    </li>
                </ul>
            </div>
            <div class="container-fluid info-main-content">
                <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">Trade Services</h1>
                        <p class="lead">An Overview of the trade services we can offer to your business</p>
                    </div>
                </div>
                <div class="jumbotron jumbotron-fluid mt-5">
                    <div class="container">
                        <p class="lead">Double'O4 Trade Finance & Services deliver comprehensive solutions to companies
                            engaged in international and domestic trade transactions. We offer a suite
                            of trade finance solutions including Letters Of Credit, Documentary Collections,
                            Banker's Guarantees, Standby Letters Of Credit and Open Account transactions.
                        </p>
                        <p class="lead">You can obtain working capital financing on any underlying trade transaction. Where
                            exporters undertake risks such as sovereign, cross-border and commercial risks, Double'O4’s
                            extension of adding confirmation to your Export Letter of Credit will help you mitigate the
                            risks of dealing with less familiar counter-parties, financial institutions or higher risk
                            countries. With the assurance of payment upon your fulfillment of underlying trade transaction
                            and documentary requirements, you will now have the confidence to expand to new markets and focus
                            on growing your business.
                        </p>
                        <p class="lead">Double'O4 can further enhance acceptability of your business propositions and financial obligations
                            by our issuance of Banker's Guarantees or Standby Letters of Credit to back up your financial and
                            performance obligations between your good company and your counter-party.
                        </p>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="card-box">
                        <h2> Our Features: </h2><br><br>
                        <div class="row card-list" id="advancedAccordion">

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title1">Import Services</p>
                                    </div>
                                </a>
                                <div id="collapse1" class="collapse hover-collapse" aria-labelledby="title1" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Double'O4 offers a wide range of import services that provide flexibility and liquidity
                                            to your business. Our Import Services includes Import Letter of Credit, Trust Receipt,
                                            Invoice Financing & Import Documentary Collection.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title2">Export Services</p>
                                    </div>
                                </a>
                                <div id="collapse2" class="collapse hover-collapse" aria-labelledby="title2" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Double'O4 offers a wide range of export services that provide flexibility and liquidity to
                                            your business. Our Export Services includes Advising of Export Letter of Credit, Negotiation
                                            of Export Letter of Credit, Transferring of Export Letter of Credit, Confirmation of Export
                                            Letter of Credit, Purchasing of Export Bill, Packing of Credit Loan, Discounting of Trade Bill,
                                            Financing of Open Account trade transaction & Export Documentary Collection.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title3">Guarantees</p>
                                    </div>
                                </a>
                                <div id="collapse3" class="collapse hover-collapse" aria-labelledby="title3" data-parent="#advancedAccordion">
                                    <div class="card-body">
                                        <p>Double'O4 is able to issue a wide range of Banker’s Guarantees and Standby Letters of Credit,
                                            including Bid Bond, Performance Bond, Warranty Bond, Advance Payment Guarantee, Financial Guarantee
                                            & Shipping Guarantee.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="card-box">
                        <h2> Benefits: </h2><br><br>
                        <div class="row card-list" id="advancedAccordion1">

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title4">Worldwide Trading Parties</p>
                                    </div>
                                </a>
                                <div id="collapse4" class="collapse hover-collapse" aria-labelledby="title4" data-parent="#advancedAccordion1">
                                    <div class="card-body">
                                        <p>Enjoy direct links with worldwide trading parties through the Double'O4 Group’s extensive network
                                            of regional office and worldwide correspondent relationships, which also assure that the Bank’s trade
                                            instruments are widely accepted.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title5">Trade Automation System</p>
                                    </div>
                                </a>
                                <div id="collapse5" class="collapse hover-collapse" aria-labelledby="title5" data-parent="#advancedAccordion1">
                                    <div class="card-body">
                                        <p>Efficient trade automation system that meets the demands of complex trade agreements with importers
                                            and exporters.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title6">Internet Banking Plus</p>
                                    </div>
                                </a>
                                <div id="collapse6" class="collapse hover-collapse" aria-labelledby="title6" data-parent="#advancedAccordion1">
                                    <div class="card-body">
                                        <p>Fully integrated Business Internet Banking Plus that allows timely and seamless electronic submission
                                            of applications and efficient update of transaction records.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse7" role="button" aria-expanded="false" aria-controls="collapse7">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title7">Click & Track</p>
                                    </div>
                                </a>
                                <div id="collapse7" class="collapse hover-collapse" aria-labelledby="title7" data-parent="#advancedAccordion1">
                                    <div class="card-body">
                                        <p>Monitor your DHL document shipment status via "Click & Track" in Business Internet Banking Plus.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-wrapper">
                                <a class="card index-card" data-toggle="collapse" href="#collapse8" role="button" aria-expanded="false" aria-controls="collapse8">
                                    <div class="card-body">
                                        <p class="card-title h5" id="title8">Trade Alerts</p>
                                    </div>
                                </a>
                                <div id="collapse8" class="collapse hover-collapse" aria-labelledby="title8" data-parent="#advancedAccordion1">
                                    <div class="card-body">
                                        <p>Receive Trade alerts on the status of your import and export transactions.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center"><b>Eligibility: All businesses incorporated in Singapore are eligible to apply for Double'O4 Trade Services.</b></p>
                </div>
            </div>
        </div>
    </main>

    <?php
    include "footer.inc.php";
    ?>
</body>

</html>