<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <?php include("../components/admin-menu.php")?>
    <section class="manage-accounts-section">
      <form action="" method="get" class="search-accounts">
        <div class="search-container">
          <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search Accounts"
          />
          <button type="submit" class="search-button">
            <i class="fas fa-arrow-right search-icon"></i>
          </button>
        </div>
      </form>

      <div class="account-container">
        <div class="info-wrap">
          <div class="profile-img-container">
              <img
                src="../../../Assets/customer-dashboard-assets/profile.png"
                alt="profile-picture"
                class="profile-picture"
              />
          </div>
          <div class="text-wrap">
              <p class="account-name">Mark</p>
              <p class="account-email">Mark@fitzone.com</p>
          </div>
        </div>
        <div class="actions-wrap">
            <i class="fas fa-pen-to-square edit-account" onclick="window.location.href='./edit-account.php?selected=Edit Account'"></i>
            <i class="fa-regular fa-circle-xmark delete-account"></i>
        </div>
      </div>
    </section>

    <script>
      const searchCont = document.querySelector(".search-container");

      searchCont.addEventListener("click", () => {
        searchCont.style.outline = "auto";
      });
      document.addEventListener("click", (e) => {
        if (!searchCont.contains(e.target)) {
          searchCont.style.outline = "none";
        }
      });
    </script>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
