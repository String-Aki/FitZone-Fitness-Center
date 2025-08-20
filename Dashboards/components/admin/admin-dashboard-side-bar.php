<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Staff-Dashboard/styles.css" />
  </head>
  <body>
    <aside class="aside-nav">
      <div class="aside-header">
        <i class="fas fa-dumbbell aside-logo"></i>
        <h1 class="logo-name">Fitzone</h1>
      </div>
      <nav class="nav-menu">
        <a href="../../Admin-Dashboard/Everything-Else/dashboard.php?header_title=Admin Dashboard" class="home-link">
          <i class="fas fa-house nav-logo"></i>
          Home
        </a>
        <a href="../../Admin-Dashboard/Everything-Else/messages.php?header_title=Messages" class="message-link">
          <i class="fa-regular fa-message nav-logo"></i>
          Messages
        </a>
        <a href="../../Admin-Dashboard/Everything-Else/customer.php?header_title=Customer Management" class="customers-link">
          <i class="fas fa-people-group nav-logo"></i>
          Customers
        </a>
        <a href="../../Admin-Dashboard/first-view.php" class="back-link">
          <i class="fa-solid fa-circle-arrow-left nav-logo"></i>
          Back
        </a>
      </nav>
      <div class="aside-footer">
        <a href="../../../includes/staff-logout.php" class="logout-link">
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
