<?php session_start();?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
                <div class="page-content minw-500">
                    <header class="">
                        <h1 class="">Welcome to Double'O4 Banking</h1>
                    </header>                  
                </div>
                <div class="page_carousel">  
                    <main class="page-content minw-500">
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
                    </main>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>
