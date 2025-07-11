const passwordToggle = document.querySelector(".pass-toggle");
const passwordField = document.querySelector(".password-field");

passwordToggle.addEventListener("click", function () {
  const type =
    passwordField.getAttribute("type") === "password" ? "text" : "password";
  passwordField.setAttribute("type", type);

  this.classList.toggle("fa-eye");
  this.classList.toggle("fa-eye-slash");

});
