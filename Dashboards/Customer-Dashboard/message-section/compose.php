<?php
session_start();
include("../../../includes/dbconnect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title>Compose</title>
  </head>
  <body>
    
    <?php include("../../components/customer-dashboard-navbar.php"); ?>

    <section class="compose-section dashboard-sections">
      <h1 class="headers messages-header">Messages</h1>
      <div class="messages-indicator indicator-div">
        <div class="manage-message">
          <h2
            onclick="window.location.href ='./compose.php'"
            class="compose sub-header"
          >
            Compose
          </h2>
          <h2
            onclick="window.location.href ='./inbox.php'"
            class="inbox sub-header"
            style="color: #637587"
          >
            Inbox
          </h2>
        </div>
      </div>
      <hr class="line"/>

      <h3 class="section-subheader">Spark a Chat with Us!</h3>

      <form action="" method="post" enctype="multipart/form-data" class="message-form all-forms">
       
        <label for="recipient">Select Recipient</label>
        <select name="recipient" id="recipient" required>
            <option value="">Select a Recipient</option>
            <?php
                    $query = "SELECT Trainer_ID, Name FROM trainers";
                    $results = $conn->query($query);

                    if($results-> num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            echo "<option value='" . $row['Trainer_ID'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
                        }
                    }

                    else {
                        echo "<option value=''>No Recipient Available</option>";
                    }
                    $results->free();
                ?>
        </select>

        <label for="topic">Inquiry Topic</label>
        <select name="inquiry-topic" id="topic" required>
          <option value="">Select a topic</option>
          <option value="Membership Inquiry">Membership Inquiry</option>
          <option value="Class Schedule">Class Schedule</option>
          <option value="Personal Training">Personal Training</option>
          <option value="Facility Access">Facility Access</option>
          <option value="Billing and Payments">Billing and Payments</option>
          <option value="Other">Other</option>
        </select>

        <label for="message-area">Message</label>
        <textarea name="message-area" id="message-area" cols="50"
        rows="3"></textarea>

        <label for="uploads">Upload (Optional)</label>
        <input type="file" name="uploads" id="uploads" class="uploads">

        <button type="submit" class="message-submit" name="message">Hit Send!</button>
      </form>
    </section>
    
      <?php
        if(isset($_POST['message'])){
          $user_id = $_SESSION['user_id'];
          $recipient_id = $_POST['recipient'];
          $topic = $_POST['inquiry-topic'];
          $message = trim($_POST['message-area']);
          $created_at = date('Y-m-d H:i:s');
          $upload_name = '';
          $upload_path = '';
          $status = 'pending';

          if(isset($_FILES['uploads']) && $_FILES['uploads']['error'] != UPLOAD_ERR_NO_FILE){
            $target_dir = "Uploads/";
            $upload_name = basename($_FILES["uploads"]["name"]);
            $upload_path = $target_dir . $upload_name;

            if(!move_uploaded_file($_FILES['uploads']['tmp_name'], $upload_path)){
              echo '<script>alert("Failed to upload file")</script>';
              exit;
            }
          }

          $sql = "INSERT INTO messages (User_ID, Recipient_ID, Topic, Message, Created_At, Upload_Name, Upload_Path, Status) VALUES (?,?,?,?,?,?,?,?)";

          $stmt = $conn->prepare($sql);
          if(!$stmt){
            echo '<script>alert("Prepare Failed")</script>';
          }

          $stmt->bind_param("ssssssss",$user_id,$recipient_id, $topic, $message, $created_at, $upload_name, $upload_path,$status);


          if($stmt->execute()){
            echo '<script>alert("Message Sent")</script>';
          }
          else{
            echo '<script>alert("Message Failed to Send")</script>';
          }
          $stmt->close();
        }
        $conn->close();
      ?>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
