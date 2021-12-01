<?php 
include "staff_session.php";
?>
<!-- Default HTML structure -->

<html>
    <?php
        include "staff_head.inc.php";
    ?>
    <body>
        <?php
            include "staff_nav.inc.php";
        ?>
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                        <h2>View System Logs as: <?php echo $_SESSION["displayName"]; ?></h2>
<!-- Default HTML structure -->
<table id="logTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Datetime</th>
                <th>Category</th>
                <th>Type</th>
                <th>Description</th>
                <th>Performed By (Username)</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th>Datetime</th>
                <th>Category</th>
                <th>Type</th>
                <th>Description</th>
                <th>Performed By (Username)</th>
            </tr>
        </tfoot>
    </table>
<!-- Default HTML structure -->
                    </div>
                </div>
            <?php
               include "staff_footer.inc.php";
            ?>
            </main>
    </body>
</html>
<!-- Default HTML structure -->