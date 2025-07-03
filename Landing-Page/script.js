const navbar = document.querySelector(".landing-page-nav");
// const branding = document.querySelector(".branding");
// const signupButtons = document.querySelector(".join-or-login");
// const menu = document.querySelector(".nav-menu")

const cards = document.querySelectorAll(".the-about-card");

// navbar hiding on scroll
window.addEventListener("scroll", () => {
  if (window.scrollY > 600) {
    // menu.classList.add("hidden");
    // signupButtons.classList.add("hidden");
    // branding.classList.add("hidden");
    navbar.classList.add("hidden");
  }
  if (window.scrollY < 10) {
    navbar.classList.remove("hidden");
    // menu.classList.remove("hidden");
    // branding.classList.remove("hidden");
    // signupButtons.classList.remove("hidden");
  }
});

// Cards Flipping
cards.forEach((card) => {
  card.addEventListener("mouseleave", () => {
    card.classList.remove("clicked");
  });

  card.addEventListener("click", () => {
    card.classList.toggle("clicked");
  });
});
