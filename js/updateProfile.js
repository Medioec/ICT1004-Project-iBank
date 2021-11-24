$(document).ready(function() {
    changepwdCheck();
} );

// For Update Profile Radio Buttons
function changepwdCheck() {
    if (document.getElementById('y_changepwd').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    
    else document.getElementById('ifYes').style.display = 'none';

};

// Go Back 1 Page Function
function goBack() {
    window.history.back();
}

// Return to home page Function
function goHome() {
    window.location.href = "./index.php";
}
