<?php session_start(); ?>
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
            <div class="container-fluid info-main-content">
                <div class="jumbotron jumbotitle jumbotron-fluid mt-5">
                    <div class="container">
                        <h1 class="display-4">Popular FAQs</h1>
                        <p>Most Frequently Asked Questions for all your enquiries</p>
                    </div>
                </div>
                <div class="row justify-content-sm-center">
                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">How can I perform a stop payment of a cheque?
                        </p>
                        <ol>
                            <li>Via Personal Internet Banking. ($5 per cheque/cheuq range)</li>
                            <li>Call Contact Centre at 1800 123 3242 or +65 1234 5678 (If you are calling from overseas)($20 per cheque/cheque range)</li>
                            <li>Visit any Double'O4 Singapore branch. ($20 per cheque/cheque range)</li>
                        </ol>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">When will I receive my credit advice for incoming TT?
                        </p>
                        <p>After the TT is successfully processed, you will be able to receive the hard copy credit advice within 2 – 3 working days.
                            For clients with Double'O4 Internet Banking Plus (DO4Plus) access, the electronic credit advice can be retrieved after the TT is successfully processed.</p>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">Why e-Statement?
                        </p>
                        <p>E-Statement is an electronic version of your paper statement in Adobe PDF format that can be retrieved through Double'O4 Online Banking. Your e-Statements
                            will be stored securely as soft copy up to 3 years from time of subscription so it is easy to retrieve at any time.</p>

                        <p>This also helps to reduce paper clutter and save time in organizing or keeping your monthly paper statements. You can receive timely bill payment reminders
                            for your credit cards and get Double'O4 Mobile Banking app push notifications or emails when your e-Statements are ready.</p>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">What is an email e-Statement?
                        </p>
                        <p>Email e-Statement is a soft copy of your account statement or credit card statement that is delivered to your latest registered email address with us.</p>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">How long is the processing time after opt-in to e-Statement?
                        </p>
                        <p>Your e-Statement is available in the immediate statement cycle if you make the selection before the statement print date. However, due to our batch
                            processing, the statement may take up to 1 to 2 working days to be available for your viewing. We also recommend subscribing to our e-Alert notification
                            through SMS and/or email so that you will be notified when your monthly statement is ready for viewing.</p>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">What is the cost of using e-Statement?
                        </p>
                        <p>This is a free service available to all customers.</p>
                    </div>

                    <div class="col-sm-10 ml-3 mr-3">
                        <p class="h4">How do I revert to paper statement?
                        </p>
                        <ol>
                            <li>Login to Online Banking with your access code and PIN</li>
                            <li>Select "Your Accounts" under the menu</li>
                            <li>Select "Manage e-Statements"</li>
                            <li>Un-check the boxes for the corresponding account/s to revert to paper statement</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>
