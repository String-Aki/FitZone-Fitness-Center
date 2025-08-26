<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard</title>
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
                            echo "Staff Dashboard";
                        }

                        if(isset($_GET['header_title']) && $_GET['header_title'] == 'Messages'){
                          echo '<i class="fas fa-plus create-message-icon"></i>';
                        }
                ?>
        </h2>

        <dialog id="create-message" class="modal-view">
      <div class="inner-wrapper">
        <div class="header-wrapper">
          <i
            class="fas fa-circle-xmark close-button close-message"
          ></i>
        </div>

        <div class="content">
          <h1 class="topic plan-type">Create Message</h1>

          <form
            method="post"
            class="create-message-form"
            action="./messages.php?uid=<?php echo htmlspecialchars($UID); ?>&header_title=Messages"
            id="message-form"
          >
          <div class="input-wrap">
              <div class="input-inner-wrap">
                  <input type="hidden" name="UID" value="<?php echo htmlspecialchars($UID); ?>"/>
                  <label for="users">Recipient</label>
                  <select name="users" id="users" class="msg-input">
                    <option value=""> Select Recipient </option>
                    <?php
                      $users_query = "SELECT First_Name, Last_Name, User_ID FROM users WHERE Role='customer'";
                      $usernames = $conn->query($users_query);

                      if($usernames->num_rows > 0){
                        while($row = $usernames->fetch_assoc()){
                          echo 
                          '
                            <option value="'.htmlspecialchars($row['User_ID']).'">
                            '."(#".htmlspecialchars($row['User_ID'].") ".$row['First_Name']." ".$row['Last_Name']).'
                            </option>
                          ';
                        }
                      }
                      $usernames->free();
                    ?>
                    
                  </select>
              </div>

              <div class="input-inner-wrap">
                  <label for="subject">Subject</label>
                  <select name="subject" id="subject" class="msg-input">
                    <option value=""> Select Topic </option>
                    <option value="Membership Inquiry">Membership Inquiry</option>
                  <option value="Class Schedule">Class Schedule</option>
                  <option value="Personal Training">Personal Training</option>
                  <option value="Facility Access">Facility Access</option>
                  <option value="Billing and Payments">Billing and Payments</option>
                  <option value="Other">Other</option>
                  </select>
              </div>
          </div>

          <label for="message" class="textarea-label">Message</label>
          <textarea name="message" id="" rows="5" class="msg-input"></textarea>

          <button type="submit" name="send-message" class="send-message">Send</button>
          </form>
        </div>
      </div>
    </dialog>

        <div class="search-container search-wrapper" data-uid="<?php echo htmlspecialchars($UID)?>" data-role="<?php echo "staff"?>">
            <input class="search-input" placeholder="Search" type="text" />
              <i class="fa-solid fa-magnifying-glass search-icon"></i>
          <div class="search-suggestions"></div>
        </div>

        <?php
          $fetch_user = "SELECT First_Name, Last_Name, Password, Profile_Img_Path FROM users WHERE Role = 'staff' AND User_ID = '$UID'";

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
                    <div class="profile-container">
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
                
                $update_password_query = "UPDATE users SET Password = ? WHERE User_ID = '".$UID."'";
                
                $stmt = $conn->prepare($update_password_query);
                $stmt->bind_param("s", $confirm_password_hash);
                
                if($stmt->execute()){
                  echo 
                  '<script>
                  alert("Password Changed Successfully!\nPlease use the new password to login henceforth.");
                  document.getElementById("change-pass").close();
                  window.location.href = "../../includes/logout.php?role=staff&uid='.htmlspecialchars($UID).'";
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
          <div class="profile-container staff-profile">
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
            <p><?php echo htmlspecialchars($user_details['First_Name']);?></p>
            <p>Staff</p>
          </div>
        </div>
      </header>

      <?php
        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
          $file = $_FILES['profile_picture'];
          $target_dir = "../../includes/Uploads/pfp/";
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
      const upload_pfp_button = document.querySelector(".staff-profile");
      const pfp_form = document.querySelector(".pfp-form");
      const input_pfp = document.querySelector(".input_pfp");

      upload_pfp_button.addEventListener("click", ()=>{
        input_pfp.click();
      });

      input_pfp.addEventListener("change", ()=>{
        pfp_form.submit();
      });

      const create_message_button = document.querySelector(".create-message-icon");
      const close_message_button = document.querySelector(".close-message");
      const message_modal = document.getElementById("create-message");

      if(create_message_button)
      {
        create_message_button.addEventListener("click", ()=>{
        message_modal.showModal();
      });

      close_message_button.addEventListener("click", ()=>{
        message_modal.close();
      })

      }
    </script>

    <script src="../../includes/search-ajax.js"></script>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>