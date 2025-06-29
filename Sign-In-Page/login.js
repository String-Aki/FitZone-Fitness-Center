const passField = document.querySelector(".pass-field");
const passToggle = document.querySelector(".toggle-pass");

passToggle.addEventListener("click", function() {
  const type =
    passField.getAttribute("type") === "password" ? "text" : "password";
  passField.setAttribute("type", type);

  this.classList.toggle("fa-eye");
  this.classList.toggle("fa-eye-slash");
});
