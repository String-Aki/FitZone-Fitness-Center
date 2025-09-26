const passField = document.querySelector(".pass-field");
const passToggle = document.querySelector(".toggle-pass");
const formView = document.querySelector(".login-form");
const screenWidth = window.innerWidth;

passToggle.addEventListener("click", function () {
  const type =
    passField.getAttribute("type") === "password" ? "text" : "password";
  passField.setAttribute("type", type);

  this.classList.toggle("fa-eye");
  this.classList.toggle("fa-eye-slash");
});

if (screenWidth < 1024) {
  setTimeout(() => {
    formView.scrollIntoView({ behavior: "smooth" });
  }, 2000);
}

document.addEventListener("DOMContentLoaded", function () {
  const isMobile = window.matchMedia(
    "only screen and (max-width: 768px)"
  ).matches;

  if (isMobile) {
    // Add a class to the body to help with styling
    document.body.classList.add("mobile-lock");

    // Disable all form elements on the page
    const formElements = document.querySelectorAll(
      "form input, form button, form select, form textarea"
    );
    formElements.forEach((element) => {
      element.disabled = true;
    });
  }
});