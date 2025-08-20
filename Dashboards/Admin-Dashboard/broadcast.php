<?php
    session_start();
    include("../../includes/dbconnect.php");
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broadcasts</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php include("../components/admin/admin-menu.php")?>

    <form action="" method="post" class="broadcast-form">
        <div class="group">
            <label for="broadcast">Share a broadcast</label>
            <textarea name="message" id="broadcast" class="broadcast-field" rows="8"></textarea>
        </div>
        <button type="submit" name="broadcast" class="broadcast-button"><i class="fas fa-microphone-lines broadcast-icon"></i> broadcast</button>
    </form>
    <?php
        if(isset($_POST['broadcast'])){
            $admin_id = $_SESSION['user_id'];
            $message = trim($_POST['message']);
            $topic = "General Announcement";

            $broadcast_query = "INSERT INTO broadcasts (Admin_ID, Topic, Announcement) VALUES (?,?,?)";
            
            $stmt = $conn->prepare($broadcast_query);
            $stmt->bind_param("iss", $admin_id, $topic, $message);

            if($stmt->execute()){
                echo '<script>alert("Announcement Broadcasted Successfully!")</script>';
            }
            else
            {
                echo '<script>alert("Failed To Broadcast")</script>';
            }
            $stmt->close();
            $conn->close();
        }
    ?>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>