<?php include "session.php";
if (!$_SESSION["sqlSuccess"]) {
    header("Location: accounts_view.php");
}
$_SESSION["sqlSuccess"] = 0;
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
                <h1>Transaction Complete</h1>
                <p>You have successfully created a new <?php echo $_SESSION["newAccountType"]; ?> account.</p>
                <p>New account no. : <?php echo $_SESSION["newAccountId"]; ?>
                <p>
                    <a type="button" class="btn btn-primary" href="<?php echo $_SESSION['originTransactionPage']; ?>">Back</a>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>

</body>

</html>