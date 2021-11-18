<?php
    if (isset($_SESSION["transferInputVerified"])) {
        if (!$_SESSION["transferInputVerified"]) {
            unset($_SESSION["accountId"]);
            unset($_SESSION["otherAccountId"]);
            unset($_SESSION["verifyTransfer"]);
            unset($_SESSION["fetchedOtherAccountId"]);
            unset($_SESSION["fetchedAccountId"]);
            unset($_SESSION["amountIn"]);
        }
    }
    $_SESSION["transferInputVerified"] = 0;
    

?>