<?php
    session_start();
    if ($_POST["confirm-logout"] != 1) {
        echo '
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to log out?<p>
        <form method="post">
            <input type="hidden" name="confirm-logout" value="1"></input>
            <div class="form-group">
                <button type="submit" class="btn btn-danger submit-button">Logout</button>
            </div>
        </form>
        ';
    } else {
        echo '
        <h2>You have successfully logged out.</h2>
        <div class="form-group">
            <a class="btn btn-primary" href="index.php">Back to homepage</a>
        </div>
        ';
        session_unset();
        session_destroy();
    }

?>