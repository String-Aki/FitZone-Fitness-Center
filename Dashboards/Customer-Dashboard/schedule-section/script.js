const bookAppointment = document.querySelector(".book-appoinment");
const manageAppointment = document.querySelector(".manage-appointment");

bookAppointment.addEventListener("click", () => {
  window.location.href = "./book-appointment.html";
  bookAppointment.style.color = "black";
  manageAppointment.style.color = "#637587";
});

manageAppointment.addEventListener("click", () => {
    window.location.href = "./manage-appointment.html";
    manageAppointment.style.color = "black";
    bookAppointment.style.color = "#637587";
});
