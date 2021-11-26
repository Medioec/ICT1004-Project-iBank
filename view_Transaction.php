<?php 
    include "session.php";
    include "php/inputCheckHandler.php";
    include "php/connect.php";
    include "php/transactionDatatable.php";
    include "php/transactionViewHandler.php";
    include "php/formValidateHelper.php";
    include "php/accountSelectHelper.php";
?>
<!DOCTYPE html>
<html>
    <?php include "head.inc.php"; ?>
    <body>
        <?php include "nav.inc.php"; ?>
        <div class="page-bg"></div>
            <div class="page-body minw-500">
                <div class="page-content minw-500">
                    <?php include "sideMenu.inc.php";?>
                    <main class="main-content">
                        <h2>View transactions</h2>
                        <form class="form-validate" method="post" novalidate>
                            <?php genericValidate();?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="account-select">Account:</label>
                                </div>
                                <select class="custom-select" id="account-select" name="accountId" required="true">
                                    <option value="">Choose account...</option>
                                    <?php generateAccountSelect($connect, 0);?>
                                </select>
                                <div class="invalid-feedback">
                                    Please make a valid selection
                                </div>
                            </div>
                            <div class="row">
                                <div class="date-entry form-group col-4">
                                    <label for="from-date">From Date:</label>
                                    <input type="date" class="form-control" id="from-date" name="fromDateIn" placeholder="From Date:"
                                    value="<?php echo sanitize_input($_POST["fromDateIn"]);?>">
                                </div>
                                <div class="date-entry form-group col-4">
                                    <label for="to-date">To Date:</label>
                                    <input type="date" class="form-control" id="to-date" name="toDateIn" placeholder="To Date:"
                                    value="<?php echo sanitize_input($_POST["toDateIn"]);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary submit-button" type="submit" name="submit-button-clicked" value="1">Submit</button>
                            </div>
                        </form>
                        <div class="table-responsive"><?php
                        if ($_POST["submit-button-clicked"] == 1) {
                            getTransaction($connect);
                        }?></div>
                    </main>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>