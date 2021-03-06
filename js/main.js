$(document).ready(function() {
    $('#example').DataTable({
        "order": [
            [0, "desc"]
        ]
    });
    $(".form-validate").on("click", ".submit-button", function(e) {
            validateForm(e);
        })
        //side menu scrollposition code
    $(window).scroll(function() {
        var content = document.getElementsByClassName("info-main-content")[0];
        if (!content) content = document.getElementsByClassName("main-content")[0];
        if (!content) return;
        var menu = document.getElementsByClassName("front-side-menu")[0];

        var domRect = content.getBoundingClientRect();

        if (menu) {
            if (domRect.bottom - window.innerHeight < 0);
            else if (window.scrollY > 349) {
                var position = window.scrollY - 350 + 100;
                menu.style.marginTop = position.toString() + "px";
            } else if (window.scrollY < 351) {
                var position = 100;
                menu.style.marginTop = position.toString() + "px";
            }
        }
        var menu = document.getElementsByClassName("user-side-menu")[0];
        if (menu) {
            if (domRect.bottom - window.innerHeight < 0);
            else if (window.scrollY != 0) {
                var position = window.scrollY + 100;
                menu.style.marginTop = position.toString() + "px";
            }
        }
    });
    activateMenu();
});

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

function activateMenu() {
    setTimeout
        (() => {
            var current_page_URL = location.href;
            $("a.nav-link").each(
                function() {
                    var target_URL = $(this).prop("href");
                    if (target_URL === current_page_URL) {
                        $('nav a').parents('li, ul').removeClass('active');
                        $(this).addClass('active');
                        return false;
                    }
                }
            );
        }, 1);
}