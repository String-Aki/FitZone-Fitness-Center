const navbar = document.querySelector(".landing-page-nav");

// navbar hiding on scroll
window.addEventListener('scroll', () => {
    if(window.scrollY > 100){
        navbar.classList.add("hidden");
    }
    else {
        navbar.classList.remove("hidden");
    }
});