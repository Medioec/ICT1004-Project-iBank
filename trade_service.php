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
                <div class="header_content">
                    <header class="">
                        <h1 class="about_header">Trade Services</h1>
                    </header>
                </div>
                <img class='trade_service' src="/images/tradeservice.jpg" alt="Trade Services">
                <div class="about_content">
                    <main class="content">
                        <div class="general_containers">
                            <h2>Overview</h2>
                            <p>Double'O4 Trade Finance & Services deliver comprehensive solutions to companies 
                                engaged in international and domestic trade transactions. We offer a suite 
                                of trade finance solutions including Letters Of Credit, Documentary Collections, 
                                Banker's Guarantees, Standby Letters Of Credit and Open Account transactions.</p>
                            
                            <p>You can obtain working capital financing on any underlying trade transaction. Where 
                                exporters undertake risks such as sovereign, cross-border and commercial risks, Double'O4’s 
                                extension of adding confirmation to your Export Letter of Credit will help you mitigate the 
                                risks of dealing with less familiar counter-parties, financial institutions or higher risk 
                                countries. With the assurance of payment upon your fulfillment of underlying trade transaction 
                                and documentary requirements, you will now have the confidence to expand to new markets and focus 
                                on growing your business.</p>
                            
                            <p>Double'O4 can further enhance acceptability of your business propositions and financial obligations 
                                by our issuance of Banker's Guarantees or Standby Letters of Credit to back up your financial and 
                                performance obligations between your good company and your counter-party.</p>
                        </div>
                    </main>
                    <div class='content'>
                        <div class="general_containers">
                            <h2>Features</h2>
                            <div class="row">
                                <div class="column" onclick="openTab('b1');">Import Services</div>
                                <div class="column" onclick="openTab('b2');">Export Services</div>
                                <div class="column" onclick="openTab('b3');">Guarantees</div>
                            </div>
                            <div id="b1" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Double'O4 offers a wide range of import services that provide flexibility and liquidity to your business. 
                                   Our Import Services includes Import Letter of Credit, Trust Receipt, Invoice Financing & Import Documentary 
                                   Collection.</p>
                            </div>

                            <div id="b2" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Double'O4 offers a wide range of export services that provide flexibility and liquidity to your business. Our Export 
                                    Services includes Advising of Export Letter of Credit, Negotiation of Export Letter of Credit, Transferring of 
                                    Export Letter of Credit, Confirmation of Export Letter of Credit, Purchasing of Export Bill, Packing of Credit Loan, 
                                    Discounting of Trade Bill, Financing of Open Account trade transaction & Export Documentary Collection.</p>
                            </div>

                            <div id="b3" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Double'O4 is able to issue a wide range of Banker’s Guarantees and Standby Letters of Credit, including Bid Bond, 
                                    Performance Bond, Warranty Bond, Advance Payment Guarantee, Financial Guarantee & Shipping Guarantee.</p>
                            </div>
                            <br>
                            <h2>Benefits</h2>
                            <div class="row">
                                <div class="column" onclick="openTab('b4');">Worldwide Trading Parties</div>
                                <div class="column" onclick="openTab('b5');">Trade Automation System</div>
                                <div class="column" onclick="openTab('b6');">Internet Banking Plus</div>
                            </div>
                            
                            <div id="b4" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Enjoy direct links with worldwide trading parties through the Double'O4 Group’s extensive network of regional 
                                    office and worldwide correspondent relationships, which also assure that the Bank’s trade instruments are 
                                    widely accepted.</p>
                            </div>

                            <div id="b5" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Efficient trade automation system that meets the demands of complex trade agreements with importers and exporters.</p>
                            </div>

                            <div id="b6" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Fully integrated Business Internet Banking Plus that allows timely and seamless electronic submission of applications 
                                    and efficient update of transaction records.</p>
                            </div>
                            
                             <div class="row">
                                <div class="column" onclick="openTab('b7');">Click & Track</div>
                                <div class="column" onclick="openTab('b8');">Trade Alerts</div>
                            </div>
                            
                            <div id="b7" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Monitor your DHL document shipment status via "Click & Track" in Business Internet Banking Plus.</p>
                            </div>

                            <div id="b8" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Receive Trade alerts on the status of your import and export transactions.</p>
                            </div>
                            <br>
                            <h2>Eligibility</h2>
                            <p>All businesses incorporated in Singapore are eligible to apply for Double'O4 Trade Services.</p>
                        </div>
                    </div>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>