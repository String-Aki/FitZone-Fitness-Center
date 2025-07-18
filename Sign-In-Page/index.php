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
    <script src="https://kit.fontawesome.com/15767cca17.js" crossorigin="anonymous"></script>
    <title>Login Page</title>
  </head>
  <body>
    <form method="post" class="login-form">
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

    <div class="img-box">
    </div>

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
          $_SESSION['user_id'] = $row['User_ID'];
          $_SESSION['username'] = $row['First_Name'];
          $_SESSION['role'] = $row['Role'];

          if($_SESSION['role'] === 'staff'){
            echo '<script>
              alert("Redirecting to staff dashboard...");
          </script>';
  
          $_SESSION['loggedIn'] = true;
          }

          elseif($_SESSION['role'] === 'admin'){
            echo '<script>
              alert("Redirecting to admin dashboard...");
          </script>';
  
          $_SESSION['loggedIn'] = true;
          }

          else{

          echo '<script>
            alert("You have successfully logged in!");
            window.location.href = "../Dashboards/Customer-Dashboard/overview-section/dashboard-overview.php";
        </script>';

        $_SESSION['loggedIn'] = true;
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
