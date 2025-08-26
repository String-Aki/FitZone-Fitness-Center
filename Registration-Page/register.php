<?php
    session_start();
    session_regenerate_id(true);
    include("../includes/dbconnect.php");
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Create Account</title>
  </head>
  <body>
    <img
      src="../Assets/registration-page-assets/register-page-image.png"
      alt="main-image"
      class="main-img"
    />
    <section class="sign-up-container">

      <a href="../index.php" class="back-home fas fa-arrow-left"></a>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="registration-form">
        <h1 class="register-heading">Sign Up</h1>
        <p class="register-p">
          Create your account and start your fitness journey with us today.
        </p>

        <div class="name-fields">
          <div>
            <label for="first-name-field">First Name</label>
            <input type="text"
             name="firstName"
             id="first-name-field"
             required/>
          </div>

          <div>
            <label for="last-name-field">Last Name</label>
            <input type="text" 
            name="lastName" 
            id="last-name-field" 
            required/>
          </div>

        </div>

        <label for="phone-number-field">Phone Number</label>
        <input
          type="tel"
          name="phoneNumber"
          id="phone-number-field"
          placeholder="e.g +(55) 123 4567 890"
          pattern="[0-9]*"
          title="Please enter only numbers"
          required
        />

        <label for="email-field">Email address</label>
        <input
          type="email"
          name="email"
          id="email-field"
          placeholder="e.g example@gmail.com"
          required
        />

        <div class="password-container">
          <label for="password-field">Password</label>
          <i class="fa-solid fa-eye pass-toggle"></i>
        </div>

        <input
          type="password"
          name="password"
          id="password-field"
          class="password-field"
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%_])[A-Za-z\d@#$_%]{8,}$"
          minlength="8"
          title="Password must be at least 8 characters and include an uppercase letter, lowercase letter, number, and special character (@#$%)."
          required
        />
        <p class="password-constraints">
          Use 8 or more characters with a mix of uppercase, lowercase, numbers & symbols
        </p>

        <button type="submit" name="signup" class="submit-button">Sign up</button>

        <div class="account-exist">
          <p>
            Already have an ccount?
            <a href="../Sign-In-Page/index.php">Log in</a>
          </p>
        </div>

      </form>
    </section>
    
    <?php
    if(isset($_POST["signup"])){
      $firstn = trim($_POST["firstName"]);
      $lastn = trim($_POST["lastName"]);
      $phonenum = trim($_POST["phoneNumber"]);
      $email = trim($_POST["email"]);
      $passw = trim($_POST["password"]);

      $check_email = "SELECT User_ID FROM users WHERE Email = ? LIMIT 1";
      $email_check_stmt = $conn->prepare($check_email);
      $email_check_stmt->bind_param("s", $email);
      $email_check_stmt->execute();
      $email_check_stmt->store_result();

      if($email_check_stmt->num_rows > 0){
        echo '<script>
                alert("Error: An account with this email address already exists.");
              </script>';
      }
      else
      {
        $hashed_password = password_hash($passw , PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (First_Name, Last_Name, Phone, Email, Password) VALUES (?, ?, ?, ?, ?)");

        if(!$stmt){
          die();
          echo '<script type="text/javascript">alert("Prepare Failed");
          </script>';
        }

        $stmt->bind_param("sssss", $firstn, $lastn, $phonenum, $email, $hashed_password);

        if($stmt->execute()){
          echo '<script type="text/javascript">alert("Account Created Successfully. Now you can login");
          window.location.href="../Sign-In-Page/index.php";
          </script>';
        }

        else{
        echo '<script type="text/javascript">alert("Error executing query");
          </script>';
        }
        $stmt->close();
      }
    }

    $conn->close();
    ?>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>

    <script 
      type="text/javascript" 
      src="./script.js"
    ></script>
  </body>
</html>

