<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Dashboards\Customer-Dashboard\style.css">
</head>
<body>
    <nav class="customer-dashboard-navbar">
        <div class="branding">
            <i class="fas fa-dumbbell logo"></i>
            <span class="logo-header">FitZone</span>
        </div>

        <div class="links-and-profile-container">
            <div class="links">
                <a href="../overview-section/dashboard-overview.php" class="nav-link">Overview</a>
                <a href="../schedule-section/book-appointment.php" class="nav-link">Schedule</a>
                <a href="../message-section/compose.php" class="nav-link">Connect</a>
                <a href="../nutrition-section/nutrition.php" class="nav-link">Nutrition</a>
            </div>
            <button class="profile-button"><img  src="../../../Assets/customer-dashboard-assets/profile.png" alt="profile-img" class="profile-img"></button>
        </div>
    </nav>

    <div class="profile-menu">
      <div class="button-seperator">
          <div class="profile-info-wrap">
            <div class="profile-img-sidebar-container"></div>
            <h1 class="username">Akira</h1>
            <p class="user-id">User ID: 1234</p>
          </div>
          <div class="wrapper-container">
            <div class="links-wrap">
              <i class="fas fa-gear link-icon"></i>
              <h2 class="account-settings-link">Account Settings</h2>
            </div>
            <div class="links-wrap">
              <i class="fa-regular fa-credit-card link-icon"></i>
              <h2 class="manage-memebership-link">Manage Memberships</h2>
            </div>
          </div>
      </div>

      <button class="logout">Logout</button>
    </div>

    <script>
        const profileToggle = document.querySelector(".profile-button");
        const profileMenu = document.querySelector(".profile-menu");
        const logout = document.querySelector(".logout");

        profileToggle.addEventListener("click", ()=>{
            profileMenu.classList.toggle("show");
            console.log("clicked");
        })

        logout.addEventListener("click", ()=>{
            window.location.href = "../../../includes/logout.php";
        })
    </script>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>