 <?php
  session_start();
  include("../../includes/dbconnect.php");
  // error_reporting(0);
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../Staff-Dashboard/styles.css" />
  </head>
  <body>
      <header>
        <h2 class="header-title">Staff Dashboard</h2>
        <form class="search-container">
          <input class="search-input" placeholder="Search" type="text" />
          <button type="submit" name="search" class="search-button">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
          </button>
        </form>

        <?php
          $fetch_user = "SELECT First_Name, Last_Name, Password, Profile_Img_Path FROM users WHERE Role = 'staff' AND User_ID = '".$_SESSION['user_id']."'";

          $details = $conn->query($fetch_user);
          $user_details = $details->fetch_assoc();

          $isPasswordDefault = (password_verify("Staff@fitzone",$user_details['Password']));

          $pfp_path = (!empty($user_details['Profile_Img_Path'])) ? $user_details['Profile_Img_Path'] : "../../Assets/customer-dashboard-assets/profile.png";
        ?>

        <?php
          if($isPasswordDefault) {
            echo '<i class="fa-solid fa-key fa-lg key" onclick="document.getElementById(\'change-pass\').showModal();"></i>
            
            <dialog id="change-pass" class="modal-view">
              <div class="inner-wrapper">
                <div class="header-wrapper">
                  <div class="profile-wrapper">
                    <div class="profile-cont">
                      <img
                        class="avatar"
                        src="'.htmlspecialchars($pfp_path).'"
                        alt="profile-img"
                      />
                    </div>
                    <p class="user-name">'.htmlspecialchars($user_details['First_Name']." ".$user_details['Last_Name']).'</p>
                </div>
                <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\'change-pass\').close();"></i>
              </div>

              <div class="content">
              <h1 class="topic plan-type">Change Password</h1>

              <form method="post" class="appointment-action-form change-password-form" id="pass-form">
                <label for="new-password">New Password</label>
                <input type="text" name="new-password" id="new-password"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%_])[A-Za-z\d@#$_%]{8,}$"
                minlength="8"
                title="Password must be at least 8 characters and include an uppercase letter, lowercase letter, number, and special character (@#$%)."
                required
                />
                <label for="confirm-password">Confirm Password</label>
                <input type="text" name="confirm-password" id="confirm-password" 
                required
                />
                <button
                  type="submit"
                  name="change-password"
                  class="confirm-button reply-button"
                >Confirm
                </button>
              </form>
              </div>
          </div>
        </dialog>
            ';

            if(isset($_POST['change-password'])){
              $new_password = trim($_POST['new-password']);
              $confirm_password = trim($_POST['confirm-password']);

              if($new_password !=  $confirm_password){
                echo 
                '<script>alert("Passwords does not match");
                document.getElementById("pass-form").reset();
                </script>';
              }
              
              else {

                $confirm_password_hash = password_hash($confirm_password, PASSWORD_DEFAULT);
                
                $update_password_query = "UPDATE users SET Password = ? WHERE User_ID = '".$_SESSION['user_id']."'";
                
                $stmt = $conn->prepare($update_password_query);
                $stmt->bind_param("s", $confirm_password_hash);
                
                if($stmt->execute()){
                  echo 
                  '<script>
                  alert("Password Changed Successfully!\nPlease use the new password to login henceforth.");
                  document.getElementById("change-pass").close();
                  window.location.href = "../../includes/logout.php";
                  </script>';
                }
                else
                  {
                    echo '<script>alert("Password Failed To Change");</>';
                  }
              }
            }
          }

          
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
            <p><?php echo htmlspecialchars($user_details['First_Name']);?></p>
            <p>Staff</p>
          </div>
        </div>
      </header>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
