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
