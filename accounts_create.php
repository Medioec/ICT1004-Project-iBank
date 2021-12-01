<?php
include "session.php";
include "php/formValidateHelper.php";
if ($_POST["submitClicked"]) {
    include "php/inputCheckHandler.php";
    include "php/connect.php";
    include "php/accountCreationHandler.php";
    createAccount($connect);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <div class="page-body minw-500">
        <div class="page-content minw-500">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h2>Create Account</h2>
                <form method="post" novalidate>
                    <div class="form-group">
                        <?php genericValidate(); ?>
                        <label for="select-type">Account Type:</label>
                        <select class="custom-select" id="select-type" name="createType" required="true">
                            <option selected>Select account type</option>
                            <option value="Checking">Checking Account</option>
                            <option value="Savings">Savings Account</option>
                        </select>
                        <div class="form-group">
                            <button class="btn btn-primary submit-button mt-3" name="submitClicked" value=1 type="submit">Create account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "footer.inc.php"; ?>
</body>

</html>