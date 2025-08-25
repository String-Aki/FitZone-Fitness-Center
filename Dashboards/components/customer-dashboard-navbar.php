<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="customer-dashboard-navbar">
        <div class="branding">
            <i class="fas fa-dumbbell logo"></i>
            <span class="logo-header">FitZone</span>
        </div>

        <div class="search-container search-wrapper" data-uid="<?php echo htmlspecialchars($UID);?>" data-role="<?php echo "customer"?>">
            <input class="search-input" placeholder="Search" type="text" />
              <i class="fa-solid fa-magnifying-glass search-icon"></i>
          <div class="search-suggestions"></div>
        </div>

        <div class="links-and-profile-container">
            <div class="links">
                <a href="../overview-section/dashboard-overview.php?uid=<?php echo htmlspecialchars($UID); ?>" class="nav-link">Overview</a>
                <a href="../schedule-section/book-appointment.php?uid=<?php echo htmlspecialchars($UID); ?>" class="nav-link">Schedule</a>
                <a href="../message-section/compose.php?uid=<?php echo htmlspecialchars($UID); ?>" class="nav-link">Connect</a>
                <a href="../nutrition-section/nutrition.php?uid=<?php echo htmlspecialchars($UID); ?>" class="nav-link">Nutrition</a>
            </div>
            <?php
              $pfp_query = $conn->query("SELECT Profile_Img_Path FROM users WHERE User_ID = '".$UID."'");
              $pfp_path = $pfp_query->fetch_assoc();
              $default_path = "../../../Assets/customer-dashboard-assets/profile.png";
              $pfp_relative = "../../../includes/Uploads/pfp/".$pfp_path['Profile_Img_Path'];
              
            ?>
            <button class="profile-button"><img  src="<?php echo !empty($pfp_path['Profile_Img_Path']) ? $pfp_relative : $default_path; ?>" alt="profile-img" class="profile-img"></button> 
        </div>
    </nav>
    <div class="profile-menu">
      <div class="button-seperator">
          <div class="profile-info-wrap">
            <div class="profile-img-sidebar-container">
              <img  src="<?php echo !empty($pfp_path['Profile_Img_Path']) ? $pfp_relative : $default_path; ?>" alt="profile-img" class="profile-img">
            </div>
            <h1 class="username"><?php echo htmlspecialchars($current_user['username'])?></h1>
            <p class="user-id"><?php echo "USER ID: ".htmlspecialchars($UID)?></p>
          </div>
          <div class="wrapper-container">
            <div class="links-wrap settings">
              <i class="fas fa-gear link-icon"></i>
              <h2 class="account-settings-link" onclick="window.location.href='../../Customer-Dashboard/settings-section/account-settings.php?uid=<?php echo htmlspecialchars($UID); ?>'">Account Settings</h2>
            </div>
            <div class="links-wrap membership">
              <i class="fa-regular fa-credit-card link-icon"></i>
              <h2 class="manage-memebership-link" onclick="window.location.href='../../Customer-Dashboard/settings-section/manage-membership.php?uid=<?php echo htmlspecialchars($UID); ?>'">Manage Memberships</h2>
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
        });

        logout.addEventListener("click", ()=>{
            window.location.href = "../../../includes/logout.php?role=customer&uid=<?= htmlspecialchars($UID);?>"
        });

        window.addEventListener("scroll", () => {
        if (window.innerWidth > 768 &&   window.scrollY > 1) {
          profileMenu.classList.remove("show");
          }
        });

        const settings_icon = document.querySelector(".fa-gear");
        const membership_icon = document.querySelector(".fa-credit-card");
        const settings_link = document.querySelector(".settings");
        const membership_link = document.querySelector(".membership");
        
          settings_link.addEventListener('mouseenter', () => {
              settings_icon.classList.add("highlight");
          });

          membership_link.addEventListener('mouseenter', () => {
            membership_icon.classList.add("highlight");
          });

          settings_link.addEventListener('mouseleave',() => {
              settings_icon.classList.remove("highlight");
          });

          membership_link.addEventListener('mouseleave',() => {
              membership_icon.classList.remove("highlight");
          });
    </script>

    <script src="../../../includes/search-ajax.js"></script>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>