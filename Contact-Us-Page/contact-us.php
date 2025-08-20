<?php
session_start();
include("../includes/dbconnect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css" />
    <title>Contact-Us</title>
  </head>
  <body>
    <!-- nav bar -->
    <nav class="nav-bar">
      <div class="branding">
        <i class="logo-icon fa-solid fa-dumbbell"></i>
        <a class="heading">FitZone</a>
      </div>

      <div class="nav-menu">
        <a href="../index.php#home" class="links">Home</a>
        <a href="../index.php#about" class="links">About</a>
        <a href="../index.php#membership-section" class="links">Membership</a>
        <a href="../index.php#testimonials" class="links">Milestones</a>
        <a href="./contact-us.php" class="links">Contact</a>
      </div>

      <div class="join-or-login">
        <a href="../Sign-In-Page/index.php" class="login">Login</a>
        <button onclick="window.location.href='../Registration-Page/register.php'" class="join-now">Join Now</button>
      </div>
    </nav>

    <a href="../index.html" class="fas fa-arrow-left back-home"></a>

    <section class="contact-us-section">
      <div class="form-container">
        <h1 class="contact-us-heading">Contact Us</h1>
        <p class="contact-p">
          We're here to help! Reach out to us with any questions or feedback.
        </p>
        <form action="" method="post" class="contact-us-form">
          <label for="name-field">Name</label>
          <input type="text" name="name" id="name-field" placeholder="Your Name" required/>

          <label for="email-field">Email</label>
          <input type="text" name="email" id="email-field" placeholder="Your Email" required/>

          <label for="phone-number-field">Phone Number</label>
          <input type="tel" name="phone" id="phone-number-field" placeholder="Your Phone Number" required/>

          <label for="subject-field">Subject</label>
          <input type="text" name="subject" id="subject-field" placeholder="Subject" required>

          <label for="message-area">Message</label>
          <textarea name="message" id="message-area" cols="50" rows="5" required></textarea>

          <button class="send" name="send_query" type="submit">Send Message</button>
        </form>
      </div>

    <?php
      if(isset($_POST['send_query'])){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        $sql = "INSERT INTO contact_queries (Name, Email, Phone_Number, Subject, 	Message) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if(!$stmt){
          die();
        }

        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if($stmt->execute()){
          echo '<script>alert("Message Sent Successfully")</script>';
        }
        else{
          echo '<script>alert("Message Failed")</script>';
        }
        $stmt->close();
      }
      $conn->close();

    ?>

      <div class="location-container">
        <h2 class="location-heading">Our Location</h2>
        <p class="location-p">Visit us at our state-of-the-art facility. We're located in the heart of the city, easily accessible by public transport and with ample parking.</p>
        <img src="../Assets/contact-us-page-assets/map-preview.png" alt="map-preview" class="map-preview">
          <h3 class="contact-info-heading">Contact Information</h3>
          <p class="contact-info">Phone: (555) 123-4567</p>
          <p class="contact-info">Email: info@fitzone.com</p>
          <p class="contact-info">Address: No.123, 2nd Lane, Kurunagale</p>
      </div>

    </section>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>

 </body>
</html>
