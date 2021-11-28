<?php session_start();?>
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
            <div class="index-page-content minw-500">
                <div class="front-side-menu" id="jsMenu">
                    <div class="side-menu-title"><h3>Links</h3></div>
                    <ul class="nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link active" href="personal_accounts.php">Accounts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Loans</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cards</a>
                        </li>
                    </ul>
                </div>
                <div class="container-fluid info-main-content">
                    <div class="jumbotron jumbotron-fluid mt-5">
                        <div class="container">
                            <h1 class="display-4">About Double'O4 Banking</h1>
                            <p class="lead">Always Listening, Always Understanding</p>
                        </div>
                    </div>
                    <div class="row justify-content-sm-center">
                    <div class="col-sm-10 ml-3 mr-3">
                        <p>Double'O4 is committed to building lasting relationships 
                        with our customers, through product and market expertise, 
                        and our promise to always do what is right.</p>
                        
                        <p>With a well-established global presence today and 
                        particularly in Asia, Double'O4 has understanding of Asian 
                        markets, corporate culture and business mindsets, which 
                        is matched by few. Our strong foothold in Singapore, 
                        Malaysia, Indonesia, Thailand and China is well-placed 
                        to create greater access and growth in this region, for 
                        our customers.</p>
                    </div>
                    </div>
                    <div class="jumbotron jumbotron-fluid mt-5" 
                        style="background-image: url('images/history.jpg');">
                        <div class="container text-on-pic">
                            <div class="row">
                            <h1 class="display-4 col-md-5">History</h1>
                            <p class="lead col">It all began during the fall of 2021 where 5 guys, Eric, Alford, Wee Yee, Ming Wei and Prince came together one night 
                            after a good ol' hearty meal decided to embark on a journey few men has ever sought to build a magical bank made with magical touches.
                            These touches are straight from the heart of these brave young men.</p>
                            </div>
                        </div>
                    </div>
                    <div class="jumbotron jumbotron-fluid mt-5" style="background-image: url('images/business.jpg');">
                        <div class="container text-on-pic">
                            <div class="row">
                            <h1 class="display-4 col-md-5">Our Business</h1>
                            <p class="lead col">Our business offers a wide range of variety from insurance to keeping your loved one's safe.</p>
                            </div>
                        </div>
                    </div>
                    <div class="jumbotron jumbotron-fluid mt-5" style="background-image: url('images/community.jpg');">
                        <div class="container text-on-pic">
                            <div class="row">
                            <div class = col>
                            <h1 class="display-4">Community Involvement</h1>
                            <p class="lead">We have helped those in need and removes interests to those who are need of money and gives them the flexibility to pay back whenever 
                            they can within a specific time frame in which they decide. The only interest free loan bank.</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "footer.inc.php";?>
    </body>
</html>
