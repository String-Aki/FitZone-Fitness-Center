<?php
    session_start();
    include("../../../includes/dbconnect.php");
    error_log(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Inbox</title>
</head>
<body>
    <?php include("../../components/customer-dashboard-navbar.php"); ?>

    <section class="inbox-section dashboard-sections">
        <h1 class="headers">Messages</h1>

        <div class="messages-indicator indicator-div">
                <div class="manage-message">
                    <h2 onclick="window.location.href ='./compose.php'" class="compose sub-header" style="color:#637587;">Compose</h2>
                    <h2 onclick="window.location.href ='./inbox.php'" class="inbox sub-header">Inbox</h2>
                </div>
            </div>
            <hr class="line">

                <?php
                    function timesinceResponded($datetime){
    
                        $now = time();
                        $response_time = strtotime($datetime);
                        $diff = $now - $response_time;
                        if ($diff < 60) {
                            return $diff . ($diff == 1 ? ' second ago' : ' seconds ago');
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
                $query = "SELECT Message_ID, Topic, Message, Response, Responded_At, Status, trainers.Name FROM messages JOIN trainers ON messages.Recipient_ID = trainers.Trainer_ID WHERE messages.User_ID = '".$_SESSION['user_id']."'";
    
                $results = $conn->query($query);
    
                if($results->num_rows > 0){
                    $inbox_header = false;
                    while($row = $results->fetch_assoc()){
                        if($row['Status'] === 'responded'){
                            if(!$inbox_header){
                                echo '<h3 class="section-subheader">Inbox Updates</h3>';
                                $inbox_header = true;
                            }
                            $dialogID = "message-popup".htmlspecialchars($row['Message_ID']);
                            echo '
                            <div class="session-log-container inbox-log" onclick="document.getElementById(\''.$dialogID.'\').showModal();">
                                <div class="info-wrap">
                                    <img src="../../../Assets/customer-dashboard-assets/profile.png" alt="profile-picture" class="profile-picture">
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
                                            <img class="profile-img" src="../../../Assets/customer-dashboard-assets/profile.png" alt="profile-img">
                                            <p class="trainer-name">'.htmlspecialchars($row['Name']).'</p>
                                        </div>
                                        <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\''.$dialogID.'\').close();"></i>
                                    </div>
                                    <div class="content">
                                        <h1 class="topic">'.htmlspecialchars($row['Topic']).'</h1>
                                        <p class="message-content"><strong class="message-header">Response:</strong> <br>'.htmlspecialchars($row['Response']).'</p>
                                        <p class="responded-time">'.timesinceResponded($row['Responded_At']).'</p>
                                            <p class="inquiry"><strong class="inquiry-header">Inquiry:</strong> <br> '.htmlspecialchars($row['Message']).'</p>
                                        </div>
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