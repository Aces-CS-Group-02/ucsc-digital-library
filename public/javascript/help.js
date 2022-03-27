const backToTopButton = document.querySelector("#back-to-top-btn");
window.addEventListener("scroll", scrollFunction);

function scrollFunction() {
    if (window.pageYOffset > 300) { //show backToTopButton
        backToTopButton.style.display = "block";
    } else { //hide backToTopButton
        backToTopButton.style.display = "none";
    }
}

backToTopButton.addEventListener("click", backToTop);

function backToTop() {
    window.scrollTo(0, 0);
}