<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../Staff-Dashboard/styles.css" />
  </head>
  <body>
      <header>
        <h2 class="header-title">
          <?php
                    if (isset($_GET['header_title'])) 
                        {
                            echo htmlspecialchars($_GET['header_title']);
                        }
                        else
                        {
                            echo "Admin Dashboard";
                        }
                ?>
        </h2>
        <form class="search-container">
          <input class="search-input" placeholder="Search" type="text" />
          <button type="submit" name="search" class="search-button">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
          </button>
        </form>

        <?php
          $pfp_path = "../../../Assets/customer-dashboard-assets/profile.png";
        ?>

        <div class="user-profile">
          <div class="profile-container">
            <img
              alt="Profile Image"
              class="avatar"
              src="<?php echo htmlspecialchars($pfp_path)?>"
            />
          </div>
          <div class="user-info">
            <p>Admin</p>
          </div>
        </div>
      </header>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
