<?php
    session_start();
    ob_start();
    if (!isset($_POST["confirm-logout"])) {
        echo '
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to log out?<p>
        <form method="post">
            <div class="form-group">
                <button type="submit" class="btn btn-danger submit-button mt-3" name="confirm-logout" value="1">Logout</button>
            </div>
        </form>
        ';
    } else {
        echo '
        <h2>You have successfully logged out.</h2>
        <p>Redirecting back to Homepage. Click on the button if the page does not redirect.</p>
        <div class="form-group">
            <a class="btn btn-primary mt-3" href="index.php">Back to homepage</a>
        </div>
        ';
        session_unset();
        session_destroy();
        header('Refresh: 3; URL=index.php');
    }

?>