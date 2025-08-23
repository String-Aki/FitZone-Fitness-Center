<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles.css" />
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
        <div class="search-container search-wrapper" data-uid="<?php echo htmlspecialchars($UID)?>" data-role="<?php echo "admin"?>">
            <input class="search-input" placeholder="Search" type="text" />
              <i class="fa-solid fa-magnifying-glass search-icon"></i>
          <div class="search-suggestions"></div>
        </div>

        <?php
          $fetch_pfp = $conn->prepare("SELECT Profile_Img_Path FROM users WHERE User_ID = ?");
          $fetch_pfp->bind_param("i", $UID);
          $fetch_pfp->execute();
          $user_details = $fetch_pfp->get_result()->fetch_assoc();
          
          $pfp_path = (!empty($user_details['Profile_Img_Path'])) ? $user_details['Profile_Img_Path'] : "../../../Assets/customer-dashboard-assets/profile.png";
          $fetch_pfp->close();
        ?>

        <div class="user-profile">
          <div class="profile-container admin-profile">
            <img
              alt="Profile Image"
              class="avatar"
              src="<?php echo htmlspecialchars($pfp_path)?>"
            />
            <form method="POST" enctype="multipart/form-data" class="upload-pfp-overlay pfp-form">
              <input type=file class="input_pfp" name="profile_picture" style="display:none"/>
              <i class="fas fa-user upload-pfp"></i>
            </form>
          </div>
          <div class="user-info">
            <p>Admin</p>
          </div>
        </div>
      </header>
      <?php
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
          $file = $_FILES['profile_picture'];
          $target_dir = "../../../includes/Uploads/pfp/";
          $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
          $new_filename = $UID.".".$file_extension;

          $target_path = $target_dir.$new_filename;

          if(move_uploaded_file($file['tmp_name'], $target_path)){
            $update_pfp = "UPDATE users SET Profile_Img_Path = ? WHERE User_ID = ?";
            $pfp_stmt = $conn->prepare($update_pfp);
            $pfp_stmt->bind_param("si", $target_path, $UID);

            if($pfp_stmt->execute()){
              echo
              '
              <script>
              window.location.href = "./dashboard.php?uid='.htmlspecialchars($UID).'"
              </script>
              ';
            }
            else
            {
              echo
              '
              <script>
                alert("Error Uploading Profile Picture");
              </script>
              ';
            }
            $pfp_stmt->close();
          }
        }

      ?>

      <script>
      const upload_pfp_button = document.querySelector(".admin-profile");
      const pfp_form = document.querySelector(".pfp-form");
      const input_pfp = document.querySelector(".input_pfp");

      upload_pfp_button.addEventListener("click", ()=>{
        input_pfp.click();
      });

      input_pfp.addEventListener("change", ()=>{
        pfp_form.submit();
      });
    </script>

      <script src="../../../includes/search-ajax.js"></script>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
