const passwordToggle = document.querySelector(".pass-toggle");
const passwordField = document.querySelector(".password-field");
const form = document.querySelector(".registration-form");
const screenWidth = window.innerWidth;

passwordToggle.addEventListener("click", function () {
  const type =
    passwordField.getAttribute("type") === "password" ? "text" : "password";
  passwordField.setAttribute("type", type);

  this.classList.toggle("fa-eye");
  this.classList.toggle("fa-eye-slash");
});

if (screenWidth < 768) {
  setTimeout(() => {
    form.scrollIntoView({ behavior: "smooth" });
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
