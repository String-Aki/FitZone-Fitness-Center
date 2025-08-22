<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <link rel="stylesheet" href="style.css">
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
        header('Location: ../../Sign-In-Page/index.php');
        exit();
    }

    include("../components/staff-dashboard-side-bar.php");?>
    
    <main>

    <?php include("../components/staff-dashboard-header.php");?>

        <section class="staff-dashboard-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Inquiry</th>
                            <th>Time of Inquiry</th>
                            <th>Response</th>
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
                                echo 
                                '
                                <tr>
                            <td>#'.htmlspecialchars($row['User_ID']).'</td>
                            <td class="full-name">'.htmlspecialchars($row['First_Name']." ".$row['Last_Name']).'</td>
                            <td>'.htmlspecialchars($row['Topic']).'</td>
                            <td>'.htmlspecialchars($row['Message']).'</td>
                            <td>'.htmlspecialchars($time_of_inquiry).'</td>
                            <td class="' . ($is_responded ? "" : "not-replied") . '">' . ($is_responded ? htmlspecialchars($row['Response']) : "Not Replied") . '</td>
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