<?php
include "session.php";
if (!isset($_SESSION["sqlFailed"])) header("Location: transfer_to_own.php")
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <main class="page-body minw-500">
        <div class="page-content minw-500">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h1>Transaction Error</h1>
                <p>An error has occured on the server side. Please try again at a later time.
                <p>
                    <a type="button" class="btn btn-primary" href="<?php echo $_SESSION["originTransactionPage"]; ?>">Back</a>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>