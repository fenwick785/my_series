
window.addEventListener("scroll", function () {
    if (window.scrollY > 50) {
        $('nav').fadeOut();
    }
    else {
        $('nav').fadeIn();
    }
}, false);
