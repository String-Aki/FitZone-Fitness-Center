<?php
session_start();
include('../includes/dbconnect.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./login.css" />
    <link rel="stylesheet" href="../Mobile-Blocker/mobile-blocker.css">
    <script src="https://kit.fontawesome.com/15767cca17.js" crossorigin="anonymous"></script>
    <title>Login Page</title>
  </head>
  <body>
    <div id="mobile-blocker">
        <div class="blocker-content">
            <a href="../index.php" class="back-home fas fa-arrow-left white"></a>
            <h1>Desktop Experience Recommended</h1>
            <p>
                Thank you for your interest! For the best experience, please
                log in or register on a desktop. The dashboards
                are not yet optimized for mobile use.
            </p>
        </div>
    </div>
    <form method="post" class="login-form">
      <a href="../index.php" class="back-home fas fa-arrow-left"></a>
      <h1 class="login-head">WELCOME BACK</h1>
      <p class="login-head-followUp">
        Welcome back! Please enter your details.
      </p>

      <label for="email" class="email-label">Email</label>
      <input
        type="email"
        placeholder="Enter your email"
        name="email"
        id="email"
        class="email-field"
      />

      <label for="password" class="pass-label">Password</label>
      <div class="password-wrap">
        <input
        type="password"
        placeholder="**********"
        name="password"
        id="password"
        class="pass-field"
        />
        <i class="fa-regular fa-eye toggle-pass"></i>
      </div>

      <div class="auth-message-container">
        <p class="auth-msg"></p>
      </div>

      <button type="submit" name="signin" class="sign-in-btn">Sign in</button>

      <p class="no-account-p">
        Don’t have an account?
        <a href="../Registration-Page/register.php" class="login-register-button">Join Fitness Zone</a>
      </p>
    </form>

    <div class="img-box"></div>

    <?php
      if(isset($_POST['signin'])){
        $email = $_POST['email'];
        $passw = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row && password_verify($passw, $row['Password'])){

          $user_id = $row['User_ID'];
          $user_role = $row['Role'];
          $username = $row['First_Name'];

          if(!isset($_SESSION['auth'])){
            $_SESSION['auth'] = [];
          }

          $_SESSION['auth'][$user_role][$user_id] = [
            'username' => $username,
            'role' => $user_role
          ];

          $redirect_url = '';
          if($user_role === 'customer'){
            $redirect_url = "../Dashboards/Customer-Dashboard/overview-section/dashboard-overview.php?uid=".$user_id;
          }
          elseif($user_role === 'staff'){
            $redirect_url = "../Dashboards/Staff-Dashboard/dashboard.php?uid=".$user_id;

          }
          elseif($user_role === 'admin'){
            $redirect_url = "../Dashboards/Admin-Dashboard/first-view.php?uid=".$user_id;
            
          }

          if($user_role === 'staff'){
            echo '<script>
              alert("Redirecting to staff dashboard...");
              window.location.href = "'.$redirect_url.'";
          </script>';
          }

          elseif($user_role === 'admin'){
            echo '<script>
              alert("Redirecting to admin dashboard...");
              window.location.href = "'.$redirect_url.'";
          </script>';
          }

          else{
          echo '<script>
            alert("You have successfully logged in!");
            window.location.href = "'.$redirect_url.'";
        </script>';
        }
        }

        else {
          echo '<script>
        const authMsg = document.querySelector(".auth-msg");
        authMsg.style.color = "red";
        authMsg.textContent = "Wrong email or password! Try Again.";
        </script>';
        }
        $stmt->close();
      }
      $conn->close();
    ?>

    <script type="text/javascript" src="./login.js"></script>
  </body>
</html>
