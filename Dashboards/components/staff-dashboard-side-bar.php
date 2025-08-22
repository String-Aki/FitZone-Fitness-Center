<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../Staff-Dashboard/styles.css" />
  </head>
  <body>
    <aside class="aside-nav">
      <div class="aside-header">
        <i class="fas fa-dumbbell aside-logo"></i>
        <h1 class="logo-name">Fitzone</h1>
      </div>
      <nav class="nav-menu">
        <a href="../Staff-Dashboard/dashboard.php?header_title=Staff Dashboard&uid=<?php echo htmlspecialchars($UID)?>" class="home-link">
          <i class="fas fa-house nav-logo"></i>
          Home
        </a>
        <a href="../Staff-Dashboard/appointments.php?header_title=Appointments&uid=<?php echo htmlspecialchars($UID)?>" class="appointments-link">
          <i class="fa-regular fa-calendar-check nav-logo"></i>
          Appointments
        </a>
        <a href="../Staff-Dashboard/messages.php?header_title=Messages&uid=<?php echo htmlspecialchars($UID)?>" class="message-link">
          <i class="fa-regular fa-message nav-logo"></i>
          Messages
        </a>
        <a href="../Staff-Dashboard/customer.php?header_title=Customer Management&uid=<?php echo htmlspecialchars($UID)?>" class="customers-link">
          <i class="fas fa-people-group nav-logo"></i>
          Customers
        </a>
      </nav>
      <div class="aside-footer">
        <a href="../../includes/logout.php?role=staff?uid=<?php echo htmlspecialchars($UID)?>" class="logout-link">
          <i class="fa-solid fa-arrow-right-from-bracket logout-logo"></i>
          Logout
        </a>
      </div>
    </aside>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
