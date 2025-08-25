<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Inbox</title>
</head>
<body>
    <?php 
    
      session_start();
      include("../../../includes/dbconnect.php");
      error_reporting(0);
      $UID = $_GET['uid'] ?? null;
      $current_user = NULL;

      if($UID && isset($_SESSION['auth']['customer'][$UID])){
          $current_user = $_SESSION['auth']['customer'][$UID];
      }

      if($current_user === NULL){
          header('Location: ../../../Sign-In-Page/index.php');
          exit();
      }

      include("../../components/customer-dashboard-navbar.php");


    //   Message Reply Handling

    if(isset($_POST['reply-trainer'])){
        $message_id = $_POST['message_id'];
        $reply = trim($_POST['reply-message']);
        $status = 'replied';
        $uid = $UID;

        $reply_to_trainer = $conn->prepare("UPDATE messages SET Message = ?, Created_At = NOW(), Status = ? WHERE Message_ID = ?");
        $reply_to_trainer->bind_param("ssi", $reply, $status, $message_id);

        if($reply_to_trainer->execute()){
            echo 
            '
            <script>
                alert("Reply Sent Successfully");
                window.location.href = "./inbox.php?uid='.$uid.'";
            </script>
            ';
        }
        else{
            echo 
            '
            <script>
                alert("Reply Failed");
                window.location.href = "./inbox.php?uid='.$uid.'";
            </script>
            ';
        }

    }

      ?>

    <section class="inbox-section dashboard-sections">
        <h1 class="headers">Messages</h1>

        <div class="messages-indicator indicator-div">
                <div class="manage-message">
                    <h2 onclick="window.location.href ='./compose.php?uid=<?php echo htmlspecialchars($UID); ?>'" class="compose sub-header" style="color:#637587;">Compose</h2>
                    <h2 onclick="window.location.href ='./inbox.php?uid=<?php echo htmlspecialchars($UID); ?>'" class="inbox sub-header">Inbox</h2>
                </div>
            </div>
            <hr class="line">

                <?php
                    function timesinceResponded($datetime){
    
                        $now = time();
                        $response_time = strtotime($datetime);
                        $diff = $now - $response_time;
                        if ($diff < 60) {
                            return ($diff == 1 ? ' second ago' : ' seconds ago');
                        } elseif ($diff < 3600) {
                            $minutes = floor($diff / 60);
                            return $minutes . ($minutes == 1 ? ' minute ago' : ' minutes ago');
                        } elseif ($diff < 86400) {
                            $hours = floor($diff / 3600);
                            return $hours . ($hours == 1 ? ' hour ago' : ' hours ago');
                        } elseif ($diff < 2592000) {
                            $days = floor($diff / 86400);
                            return $days . ($days == 1 ? ' day ago' : ' days ago');
                        } else {
                            $months = floor($diff / 2592000);
                            return $months . ($months == 1 ? ' month ago' : ' months ago');
                        }
                    }
                ?>

                

                <?php
                $fetch_broadcast = "SELECT broadcasts.*, users.Profile_Img_Path FROM broadcasts JOIN users ON broadcasts.Admin_ID = users.User_ID";
                $broadcast_result = $conn->query($fetch_broadcast);

                if($broadcast_result->num_rows > 0){
                   echo '<h3 class="section-subheader">Announcements</h3>';
                   while($broadcast = $broadcast_result->fetch_assoc()){
                    
                    $ShortMessage = implode(' ', array_slice(explode(' ', $broadcast['Announcement']), 0, 3)) . " . . .";
                    $dialogID = "message-popup".htmlspecialchars($broadcast['Broadcast_ID']);
                    
                            echo '
                            <div class="session-log-container inbox-log" onclick="document.getElementById(\''.$dialogID.'\').showModal();">
                                <div class="info-wrap">
                                    <div class="profile-cont"><img src="'.htmlspecialchars($broadcast['Profile_Img_Path']).'" alt="profile-picture" class="profile-picture"></div>
                                        <div class="text-wrap">
                                            <p class="log-header">'.htmlspecialchars($ShortMessage).'</p>
                                            <p class="log-subheader">'.htmlspecialchars($broadcast['Topic']).'</p>
                                        </div>
                                </div>
                                <p class="time">'.timesinceResponded($broadcast['Created_At']).'</p>
                            </div>

                            <dialog id="'.$dialogID.'" class="message-view">
                                <div class="inner-wrapper">
                                    <div class="header-wrapper">
                                        <div class="profile-wrapper">
                                            <div class="profile-cont"><img class="profile-img" src="../../../Assets/customer-dashboard-assets/profile.png" alt="profile-img"></div>
                                            <p class="trainer-name">Admin</p>
                                        </div>
                                        <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\''.$dialogID.'\').close();"></i>
                                    </div>
                                    <div class="content">
                                        <h1 class="topic">'.htmlspecialchars($broadcast['Topic']).'</h1>
                                        <p class="message-content"><strong class="message-header">Message:</strong> <br>'.htmlspecialchars($broadcast['Announcement']).'</p>
                                        <p class="responded-time">'.timesinceResponded($broadcast['Created_At']).'</p>
                                        </div>
                                    </div>
                                </div>
                            </dialog>

                            ';
                   }
                }

                else
                {
                    echo '<h3 class="section-subheader">No Announcements</h3>';
                }
            ?>
    
            <?php
                $query = "SELECT m.Message_ID, m.Topic, m.Message, m.Response, m.Responded_At, m.Status, t.Name, u.Profile_Img_Path FROM messages AS m JOIN trainers AS t ON m.Recipient_ID = t.Trainer_ID JOIN users AS u ON t.User_ID = u.User_ID WHERE m.User_ID = '".$UID."'";
    
                $results = $conn->query($query);
                if($results->num_rows > 0){
                    $inbox_header = false;
                    while($row = $results->fetch_assoc()){
                        if($row['Status'] === 'responded' || $row['Status'] === 'sent' ){
                            if(!$inbox_header){
                                echo '<h3 class="section-subheader">Inbox Updates</h3>';
                                $inbox_header = true;
                            }
                            $dialogID = "message-popup".htmlspecialchars($row['Message_ID']);

                            $pfp_path = (!empty($row['Profile_Img_Path'])) ? "../".$row['Profile_Img_Path'] : "../../../Assets/customer-dashboard-assets/profile.png";

                            $dialogContent = $row['Status']== 'sent' ? 
                                    '<div class="content">
                                    <h1 class="topic">'.htmlspecialchars($row['Topic']).'</h1>
                                    <p class="message-content">
                                        <strong class="message-header">Message:</strong>
                                        <br />'.htmlspecialchars($row['Response']).'
                                    </p>
                                    <p class="responded-time">'.timesinceResponded($row['Responded_At']).'</p>
                                    <form method="post" class="reply-form">
                                        <input
                                        type="hidden"
                                        name="message_id"
                                        value="' . htmlspecialchars($row['Message_ID']) . '"
                                        />
                                        <label for="response">Reply Message</label>
                                        <textarea
                                        name="reply-message"
                                        id="response"
                                        rows="5"
                                        class="reply-field"
                                        ></textarea>
                                        <button type="submit" name="reply-trainer" class="reply-button">
                                        Reply
                                        </button>
                                    </form>
                                </div>' : 
                                '<div class="content">
                                        <h1 class="topic">'.htmlspecialchars($row['Topic']).'</h1>
                                        <p class="message-content"><strong class="message-header">Response:</strong> <br>'.htmlspecialchars($row['Response']).'</p>
                                        <p class="responded-time">'.timesinceResponded($row['Responded_At']).'</p>
                                            <p class="inquiry"><strong class="inquiry-header">Inquiry:</strong> <br> '.htmlspecialchars($row['Message']).'</p>
                                        </div>';

                            echo '
                            <div class="session-log-container inbox-log" onclick="document.getElementById(\''.$dialogID.'\').showModal();">
                                <div class="info-wrap">
                                    <div class="profile-cont"><img src="'.htmlspecialchars($pfp_path).'" alt="profile-picture" class="profile-picture"></div>
                                        <div class="text-wrap">
                                            <p class="log-header">'.htmlspecialchars($row['Name']).'</p>
                                            <p class="log-subheader">'.htmlspecialchars($row['Topic']).'</p>
                                        </div>
                                </div>
                                <p class="time">'.timesinceResponded($row['Responded_At']).'</p>
                            </div>

                            <dialog id="'.$dialogID.'" class="message-view">
                                <div class="inner-wrapper">
                                    <div class="header-wrapper">
                                        <div class="profile-wrapper">
                                            <div class="profile-cont"><img class="profile-img" src="'.htmlspecialchars($pfp_path).'" alt="profile-img"></div>
                                            <p class="trainer-name">'.htmlspecialchars($row['Name']).'</p>
                                        </div>
                                        <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\''.$dialogID.'\').close();"></i>
                                    </div>
                                    '.$dialogContent.'
                                    </div>
                                </div>
                            </dialog>

                            ';
                        }
                        elseif(($row['Status'] === 'responded') == 0 && !$inbox_header) {
                                echo '<h3 class="section-subheader">No New Messages</h3>';
                                $inbox_header = true;
                            }
                    }
                }
                $conn->close();
            ?>
    </section>
</body>
</html>