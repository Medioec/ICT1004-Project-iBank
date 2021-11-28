<?php session_start();?>
<html>
    <?php
        include "head.inc.php";
    ?>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <div class='page-bg'></div>
            <div class="page-body minw-500">
                <div class="general_header">
                    <header>
                        <h1 class='about_header'>Bank with Double'O4</h1>
                        <p>Run your business efficiently with our 
                            24/7 digital banking, islandwide branches, and dedicated SME resources.</p>
                    </header>
                </div>
                <div class="general_content">
                    <h3 class="about_header">Ways to Bank</h3>
                    <main class="content">
                        <section class="bwu_section">
                            <div class="card" style="width: 20rem;">
                                <img class="card-img-top" src="images/onlinebanking.jpg" alt="Internet Banking">
                                <div class="card-body">
                                    <h5 class="card-title">Business Internet Banking</h5>
                                    <p class="card-text">The digital banking platform for businesses that's fast, secure, and easy to use.</p>
                                    <a href="#" class="btn btn-primary">Internet Banking</a>
                                </div>
                            </div>
                        </section>
                        <section class="bwu_section">
                            <div class="card" style="width: 20rem;">
                                <img class="card-img-top" src="images/tradecounters.jpg" alt="Trade Counters">
                                <div class="card-body">
                                    <h5 class="card-title">Trade Counters</h5>
                                    <p class="card-text">Collect trade documents or submit forms at dedicated counters islandwide.</p>
                                    <a href="#" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </section>
                        <section class="bwu_section">
                            <div class="card" style="width: 20rem;">
                                <img class="card-img-top" src="images/atm.jpg" alt="ATMs & Branches">
                                <div class="card-body">
                                    <h5 class="card-title">ATMs & Branches</h5>
                                    <p class="card-text">Visit your nearest Double'O4 branch or any of our self-service machines and ATMs.</p>
                                    <a href="#" class="btn btn-primary">Find Us</a>
                                </div>
                            </div>
                        </section>
                    </main>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>
