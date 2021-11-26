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

// For Password Eye
//var toggle_pwd = document.querySelector('#togglePwd,#toggleCfmPwd,toggleNewPwd');
const toggle_pwd = document.querySelector('#togglePwd');
const pwd = document.querySelector('#pwd');

toggle_pwd.addEventListener('click', function (e) {
    const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
    pwd.setAttribute('type', type);
    this.classList.toggle('bi-eye');
});

const toggle_cfmpwd = document.querySelector('#toggleCfmPwd');
const cfm_pwd = document.querySelector('#cfm_pwd');

toggle_cfmpwd.addEventListener('click', function (e) {
    const type = cfm_pwd.getAttribute('type') === 'password' ? 'text' : 'password';
    cfm_pwd.setAttribute('type', type);
    this.classList.toggle('bi-eye');
});


const toggle_newpwd = document.querySelector('#toggleNewPwd');
const new_pwd = document.querySelector('#new_pwd');

toggle_newpwd.addEventListener('click', function (e) {
    const type = new_pwd.getAttribute('type') === 'password' ? 'text' : 'password';
    new_pwd.setAttribute('type', type);
    this.classList.toggle('bi-eye');
});
