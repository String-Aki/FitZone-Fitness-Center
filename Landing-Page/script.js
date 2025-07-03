const navbar = document.querySelector(".landing-page-nav");
const branding = document.querySelector(".branding");
const signupButtons = document.querySelector(".join-or-login");
const menu = document.querySelector(".nav-menu")
const aboutScroll = document.getElementById("about");

// navbar hiding on scroll
window.addEventListener('scroll', () => {
    if(window.scrollY > 500){
        menu.classList.add("hidden");
        signupButtons.classList.add("hidden");
        navbar.classList.add("hidden");
        branding.classList.add("hidden");
        
    }
    if(window.scrollY < 10) {
        navbar.classList.remove("hidden");
        menu.classList.remove("hidden");
        branding.classList.remove("hidden");
        signupButtons.classList.remove("hidden");
    }
});


branding.addEventListener("click", () => {
    if(window.scrollY > 0){
        
    }
})
