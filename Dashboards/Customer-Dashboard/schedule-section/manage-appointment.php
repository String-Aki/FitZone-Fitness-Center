<?php
    session_start();
    include("../../../includes/dbconnect.php");
    error_log(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Manage Appointment</title>
</head>
<body>
        <?php include("../../components/customer-dashboard-navbar.php");?>

    <section class="book-appointment dashboard-sections">
        <h1 class="headers">My Schedule</h1>
        <div class="Schedule-indicator indicator-div">
                <div class="manage-schedule">
                    <h2 onclick="window.location.href = './book-appointment.php'" class="book-appointment sub-header" style="color:#637587;">Book Appointment</h2>
                    <h2 onclick="window.location.href = './manage-appointment.php'" class="manage-appointment sub-header">Manage Appointment</h2>
                </div>
            </div>
            <hr class="line">
        </div>

        <h3 class="section-subheader upcoming">Upcoming</h3>

            <?php
                $fetch_query = "SELECT appointments.Session_Type, trainers.Name as Trainer_Name FROM appointments JOIN trainers ON trainers.Trainer_ID = appointments.Trainer_ID WHERE appointments.User_ID = '".$_SESSION['user_id']."'";

                $results = $conn->query($fetch_query);
        
                if($results->num_rows > 0){
                    while($row = $results->fetch_assoc()){
                        echo '<div class="session-log-container">
                                <div class="info-wrap">
                                <i class="fas fa-calendar log-marker"></i>
                                <div class="text-wrap">
                                <p class="log-header">'.htmlspecialchars($row['Session_Type']).'</p>
                                <p class="choosen-trainer">Trainer: '.htmlspecialchars($row['Trainer_Name']).'</p>
                                </div>
                                </div>
            
                                <button class="manage">Manage</button>
                            </div>';
                            }
                        }
                    ?>
    </section>

        <script type="text/javascript" src="./script.js"></script>
        <script src="https://kit.fontawesome.com/15767cca17.js" crossorigin="anonymous"></script>
</body>
</html>