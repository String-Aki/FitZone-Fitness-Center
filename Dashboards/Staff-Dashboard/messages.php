<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <?php 
    session_start();
    include("../../includes/dbconnect.php");

    $UID = $_GET['uid'] ?? null;
    $current_user = NULL;

    if($UID && isset($_SESSION['auth']['staff'][$UID])){
        $current_user = $_SESSION['auth']['staff'][$UID];
    }

    if($current_user === NULL){
        // header('Location: ../../Sign-In-Page/index.php');
        // exit();
    }

    include("../components/staff-dashboard-side-bar.php");?>
    
    <main>

    <?php include("../components/staff-dashboard-header.php");
    
    // Send Message Handling

    if(isset($_POST['send-message'])){
        $recived_UID = $_POST['UID'];
        $user = $_POST['users'];
        $subject = $_POST['subject'];
        $message = trim($_POST['message']);
        $status = 'sent';
        $created_at = NULL;

        $send_message = "INSERT INTO messages (User_ID, Recipient_ID, Topic, Created_At, Response, Status) VALUES (?,?,?,?,?,?)";

        $fetch_trainerID = $conn->query("SELECT Trainer_ID From trainers WHERE User_ID = '$recived_UID'");
        $row = $fetch_trainerID->fetch_assoc();


        $stmt = $conn->prepare($send_message);
        $stmt->bind_param("iissss", $user, $row['Trainer_ID'], $subject, $created_at, $message, $status);
        
        if($stmt->execute()){
            echo 
            '
            <script>
                alert("Message Sent Successfully");
                window.location.href = "./messages.php?uid='.htmlspecialchars($recived_UID).'&header_title=Messages";
            </script>
            ';
        }
        else{
            echo 
            '
            <script>
                alert("Failed To Send");
                window.location.href = "./messages.php?uid='.htmlspecialchars($recived_UID).'&header_title=Messages";
            </script>
            ';
        }
        $fetch_trainerID->free();
        $stmt->close();
    }
    ?>

        <section class="staff-dashboard-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Incoming Message</th>
                            <th>Last Update</th>
                            <th>Outgoing Message</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $fetch_messages = "SELECT messages.*, users.First_Name, users.Last_Name, users.User_ID FROM messages JOIN users ON users.User_ID = messages.User_ID JOIN trainers ON messages.Recipient_ID = trainers.Trainer_ID WHERE trainers.User_ID = '".$UID."'";

                        $messages = $conn->query($fetch_messages);
                        
                        if($messages->num_rows > 0 ){

                            while($row = $messages->fetch_assoc()){

                                $time_of_inquiry = date('m-d-Y g:i A', strtotime($row['Created_At']));

                                if (substr($row['Upload_Path'], 0, 3) === '../') {
                                    $path = substr($row['Upload_Path'], 3);
                                    }
                                    else {
                                    $path = "";
                                    }
                                
                                $is_disabled = empty($row['Upload_Path']);
                                $is_responded = !empty($row['Response']);
                                $is_replied = !empty($row['Message']);
                                
                                !empty($row['Created_At']) ? $time_of_inquiry = date('m-d-Y g:i A', strtotime($row['Created_At'])) : $time_of_inquiry = "No Updates";

                                $toUpperStatus = ucfirst($row['Status']);
                                echo 
                                '
                                <tr>
                            <td>#'.htmlspecialchars($row['User_ID']).'</td>
                            <td class="full-name">'.htmlspecialchars($row['First_Name']." ".$row['Last_Name']).'</td>
                            <td>'.htmlspecialchars($row['Topic']).'</td>
                            <td class="' . ($is_replied ? "" : "not-responded") . '">' . ($is_replied ? htmlspecialchars($row['Message']) : "No Updates") . '</td>
                            <td class="' . (empty($row['Created_At']) ? "not-responded" : "") . '">'.htmlspecialchars($time_of_inquiry).'</td>
                            <td class="' . ($is_responded ? "" : "not-responded") . '">' . ($is_responded ? htmlspecialchars($row['Response']) : "(Yet To Respond)") . '</td>
                            <td>
                            '.htmlspecialchars($toUpperStatus).'
                            </td>
                            <td>
                                <a href="'.htmlspecialchars($path).'" 
                                class="action-button '.($is_disabled ? 'disabled-link' : '').'" 
                                '.($is_disabled ? ' onclick="return false;"' : '').' download>
                                <i class="fas fa-file-arrow-down download-icon"></i>
                                </a>

                            </td>
                        </tr>
                                ';
                            }
                        }else {
                            echo 
                            '<tr>
                                <td colspan="8" style="text-align:center; font-size:1.5vw; font-weight:500;">No new messages</td>
                            </tr>';
                        }
                    ?>                        
                    </tbody>
                </table>
            </div>
        </section>
    </main>
<script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>