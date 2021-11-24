$(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 0, "desc" ]]
    });
    $(".form-validate").on("click", ".submit-button", function (e) 
            {
                validateForm(e);
            }
        )
    
    changepwdCheck();
} );

// For Update Profile Radio Buttons
function changepwdCheck() {
    if (document.getElementById('y_changepwd').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    
    else document.getElementById('ifYes').style.display = 'none';

};
//Validates forms using bootstrap styling
function validateForm(e) {
    var inputList = document.querySelectorAll(".form-control,.form-check-input");
    var valid = 1;
    for (const element of inputList) {
        if (!element.validity.valid) {
            $(element).addClass("is-invalid");
            valid = 0;
        } else {
            $(element).removeClass("is-invalid");
        }
    }

    inputList = document.getElementsByClassName("custom-select");
    for (const element of inputList) {
        if (element.value == "") {
            $(element).addClass("is-invalid");
            valid = 0;
        } else {
            $(element).removeClass("is-invalid");
        }
    }
    if (!valid) {
        e.preventDefault();
    }
};

// Go Back 1 Page Function
function goBack() {
    window.history.back();
}

// Return to home page Function
function goHome() {
    window.location.href = "./index.php";
}
