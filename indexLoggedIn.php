<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<script src="js/accountchart.js"></script>

<?php
session_start();
include "head.inc.php";
?>

<body>
    <?php
    include "nav.inc.php";
    ?>
    <div class='page-bg'></div>
    <main class="page-body minw-500">
        <div class="page-content minw-500">
            <div class="container">
                <?php
                include 'php/homepage.php';
                ?>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>

</body>

</html>