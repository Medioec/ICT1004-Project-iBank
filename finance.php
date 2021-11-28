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
                        <h1 class="about_header">Asset Financing</h1>
                    </header>
                </div>
                <img class='finance' src="images/finance.jpg" alt="Asset Financing">
                <div class="about_content">
                    <main class="content">
                        <div class="general_containers">
                            <h2>Overview</h2>
                            <p>As a leading bank in Asia, our core strength lies in our 
                                ability to combine our industry-specific knowledge and experience 
                                to deliver innovative financial solutions to meet our customers’ 
                                changing needs. As you make your next capital expenditure to expand 
                                your business or to enhance your business capabilities, we can provide
                                the suitable financial solution to achieve your business goals.</p>
                            
                            <p>At Double'O4 Corporate Banking, we understand that to expand your business 
                                or to enhance your business capabilities, companies need to make capital 
                                investments. Be it a purchase of equipment/ commercial vehicles or, buying 
                                of new land/ property or renewing or building up your fleet of aircraft, our 
                                dedicated team of Product Sales Specialists and Relationship Managers have 
                                the expertise to help you efficiently acquire the fixed assets.</p>
                        </div>
                    </main>
                    <div class='content'>
                        <div class="general_containers">
                            <h2>Features</h2>
                            <div class="row">
                                <div class="column" onclick="openTab('b1');">Commercial & Industrial Property Loan</div>
                                <div class="column" onclick="openTab('b2');">Machinery / Equipment Financing</div>
                                <div class="column" onclick="openTab('b3');">SME HP Facility / Equipment & Factory Loan</div>
                            </div>
                            <div id="b1" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Enjoy Attractive interest rates, Higher financing quantum & Flexible financing structure 
                                   ( a combination of overdraft / term loan/ trade facilities is available)</p>
                                <p>All businesses incorporated in Singapore are eligible to apply.</p>
                            </div>

                            <div id="b2" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Enjoy competitive interest rates & the choice of financing of either hire purchase facility or term loan.</p>
                                <p>All businesses incorporated in Singapore are eligible to apply.</p>
                            </div>

                            <div id="b3" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Administered by SPRING Singapore, Financing of up to $15million & Loan tenure of up to 8 
                                    years for SME HP/ SME equipment loan & 10 years for SME factory loan.</p>
                                <p>Company registered & operating in Singapore with at least 30% local shareholding & group^ 
                                    annual sales turnover of <=S$100m or group employment <= 200 are eligible.</p>
                            </div>
                            <div class="row">
                                <div class="column" onclick="openTab('b4');">Asset Based Financing Under IF Scheme</div>
                                <div class="column" onclick="openTab('b5');">Aircraft Financing</div>
                                <div class="column" onclick="openTab('b6');">Commercial Vehicle Financing</div>
                            </div>
                            <div id="b4" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>Administered by IE Singapore, Financing purchase/ construction of factories / buildings / fixed assets 
                                    (such as machinery/ equipment) for overseas use. We provide funding of up to S$30m (on group basis) 
                                    and loan tenure of up to 6 years for fixed assets & 15 years for factories.</p>
                                <p>Companies who are eligible must either be a Singapore-based company with meaningful business operations and 
                                    at least 3 strategic business functions in Singapore. For non-trading companies, the turnover shall not 
                                    exceed S$300 million. For trading companies, the turnover shall not exceed S$500 million.</p>
                            </div>

                            <div id="b5" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>We have flexible financing structure to finance the growth of your fleet, competitive interest rates and 
                                you can customized repayment terms which helps you to manage your cash flow.</p>
                                <p>All businesses incorporated in Singapore are eligible to apply.</p>
                            </div>

                            <div id="b6" class="containerTab">
                                <span onclick="this.parentElement.style.display='none'" class="closebtn">x</span>
                                <p>We provide High Financing quantum, hire Purchase financing available for commercial vehicle and commercial 
                                    vehicle with renewed COE and obtaining ownership of the vehicle upon fulfilling payment of loan installment.</p>
                                <p>All businesses incorporated in Singapore are eligible to apply.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>