$(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 0, "desc" ]]
    });
    $(".form-validate").on("click", ".submit-button", function (e) 
            {
                validateForm(e);
            }
        )
    
} );

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

// Grid Function
function openTab(tabName) {
  var i, x;
  x = document.getElementsByClassName("containerTab");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(tabName).style.display = "block";
}
