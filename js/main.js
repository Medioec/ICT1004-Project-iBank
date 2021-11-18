$(document).ready(function() {
    $('#example').DataTable();
    $(".form-validate").on("click", ".submit-button", function (e) 
            {
                validateForm(e);
            }
        )
    
    changepwdCheck();
} );


function changepwdCheck() {
    if (document.getElementById('y_changepwd').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    
    else document.getElementById('ifYes').style.display = 'none';

};

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
