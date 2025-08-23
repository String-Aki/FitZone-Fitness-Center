<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Manage Appointment</title>
</head>
<body>
        <?php 
        session_start();
        include("../../../includes/dbconnect.php");

        $UID = $_GET['uid'] ?? null;
        $current_user = NULL;

        if($UID && isset($_SESSION['auth']['customer'][$UID])){
            $current_user = $_SESSION['auth']['customer'][$UID];
        }

        if($current_user === NULL){
            header('Location: ../../../Sign-In-Page/index.php');
            exit();
        }

        include("../../components/customer-dashboard-navbar.php");?>

    <section class="book-appointment dashboard-sections">
        <h1 class="headers">My Schedule</h1>
        <div class="Schedule-indicator indicator-div">
            <div class="manage-schedule">
                <h2 onclick="window.location.href = './book-appointment.php?uid=<?php echo htmlspecialchars($UID); ?>'" class="book-appointment sub-header" style="color:#637587;">Book Appointment</h2>
                <h2 onclick="window.location.href = './manage-appointment.php?uid=<?php echo htmlspecialchars($UID); ?>'" class="manage-appointment sub-header">Manage Appointment</h2>
            </div>
        </div>
            <hr class="line">

            <?php
                $fetch_query = "SELECT appointments.Appointment_ID, appointments.Session_Type, appointments.Status, trainers.Name as Trainer_Name FROM appointments JOIN trainers ON trainers.Trainer_ID = appointments.Trainer_ID WHERE appointments.User_ID = '$UID'";

                $results = $conn->query($fetch_query);
        
                if($results->num_rows > 0){
                    $pastDisplayed = false;
                    echo '<h3 class="section-subheader">Upcoming</h3>';

                    while($row = $results->fetch_assoc()){
                        if($row['Status'] === "pending"){
                            echo '
                        <div class="session-log-container">
                        <div class="info-wrap">
                        <i class="fas fa-calendar log-marker"></i>
                        <div class="text-wrap">
                        <p class="log-header">'.htmlspecialchars($row['Session_Type']).'</p>
                        <p class="log-subheader">Trainer: '.htmlspecialchars($row['Trainer_Name']).'</p>
                        </div>
                        </div>
                        <button onclick="window.location.href=\'./edit-appointment.php?edit_id='. $row['Appointment_ID'] .'&uid='.htmlspecialchars($UID).'\'" class="manage">Manage</button>
                        </div>';
                       }

                       elseif($row['Status'] === "confirmed"){
                            echo '
                        <div class="session-log-container">
                        <div class="info-wrap">
                        <i class="fas fa-calendar log-marker"></i>
                        <div class="text-wrap">
                        <p class="log-header">'.htmlspecialchars($row['Session_Type']).'</p>
                        <p class="log-subheader">Trainer: '.htmlspecialchars($row['Trainer_Name']).'</p>
                        </div>
                        </div>
                        <p>' . htmlspecialchars($row['Status']) . '</p>
                        </div>';
                       }
                    }

                    $results->data_seek(0);

                    while($row = $results->fetch_assoc()){
                        if($row['Status'] === "completed"|| $row['Status'] === "cancelled"){
                            if(!$pastDisplayed){
                            echo '<h3 class="section-subheader">Past</h3>';
                            $pastDisplayed = true;
                        }
                        echo '
                       <div class="session-log-container">
                       <div class="info-wrap">
                       <i class="fas fa-calendar log-marker"></i>
                       <div class="text-wrap">
                       <p class="log-header">'.htmlspecialchars($row['Session_Type']).'</p>
                       <p class="choosen-trainer">Trainer: '.htmlspecialchars($row['Trainer_Name']).'</p>
                       </div>
                       </div>
                       <p class="past-log">'.htmlspecialchars($row['Status']).'</p>
                       </div>';
                    }
                }
                    
                }
                else {
                    echo '
                        <h3 class="section-subheader">You have no appointments scheduled</h3>
                        ';
                    }
                    $results->free();
                    $conn->close();
            ?>
    </section>
        <script src="https://kit.fontawesome.com/15767cca17.js" crossorigin="anonymous"></script>
</body>
</html>