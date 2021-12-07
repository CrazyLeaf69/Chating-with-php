// navbar fix
$(document).ready(async function(){
    if (window.innerWidth>767) {
        $(".nav-toggle").attr("style","display: block;");
    }
    else {
        $(".nav-toggle").attr("style","display: none;");
    }
  });
window.addEventListener('resize', reportWindowSize);

$( "#burgerbtn" ).click(function() {
    setTimeout(() => {
        if ($(".collapsed").length > 0) {
            $(".jumbotron").attr("style","display: flex;");
        }
        else {
            $(".jumbotron").attr("style","display: none;");
        }
    }, 0);
  });

function reportWindowSize() {
    if (window.innerWidth>767) {
        $(".nav-toggle").attr("style","display: block;");
    }
    else {
        $(".nav-toggle").attr("style","display: none;");
    }
}


// active function
const currentsite = window.location.href
const a = document.querySelectorAll(".navbar-brand")
a.forEach((element, index) => {
    if (element.href == currentsite) {
        a[index].className = "link navbar-brand active";
    }
    else {
        a[index].className = "link navbar-brand";
    }
});