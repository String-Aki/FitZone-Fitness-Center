document.addEventListener("DOMContentLoaded", () => {

  const navbar = document.querySelector(".landing-page-nav");
  const cards = document.querySelectorAll(".the-about-card");
  const stars = document.querySelectorAll(".stars");
  const pseudoNav = document.querySelector(".pseudo-nav");

  // navbar hiding on scroll
  window.addEventListener("scroll", () => {
    if (window.scrollY > 600) {
      navbar.classList.add("hidden");
      pseudoNav.classList.add("show");
    }
    if (window.scrollY < 10) {
      navbar.classList.remove("hidden");
      pseudoNav.classList.remove("show");
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

  // Generating Stars
  stars.forEach((starContainer) => {
    for (let i = 0; i < 5; i++) {
      const starIcon = document.createElement("i");
      starIcon.classList.add("fas", "fa-star");
      starContainer.appendChild(starIcon);
    }
  });
  
});
