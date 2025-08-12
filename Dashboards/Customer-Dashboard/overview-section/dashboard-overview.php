<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Dashboard Overview</title>
</head>
<body>
   <?php include("../../components/customer-dashboard-navbar.php");
    $isLoggedIn = isset($_SESSION['loggedIn']);
    $isLoggedId = isset($_SESSION['user_id']);
    ?>
   
    <section class="overview dashboard-sections">
        <?php if($isLoggedIn): ?>
        <h1 class="welcome headers">Welcome Back, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <?php endif; ?>
        <div class="overview-indicator indicator-div">
            <h2 class="overview sub-header">Overview</h2>
            <hr class="line">
        </div>
        <h3 class="next-class-header overview-subheaders section-subheader">Your next class</h3>

        <?php
            $fetch_activity = "SELECT Session_Type, Session_Date, Session_Time, Status, trainers.Name AS Trainer_Name FROM appointments JOIN trainers ON trainers.Trainer_ID = appointments.Trainer_ID WHERE appointments.User_ID = '".$_SESSION['user_id']."' ORDER BY Session_Date, Session_Time";

            $activity_result = $conn->query($fetch_activity);
            $nextClass = false;
            while($class = $activity_result->fetch_assoc()){
            if($class['Status'] == 'confirmed' && strtotime($class['Session_Date']) >= strtotime(date("Y-m-d")) ){
                $nextClass = $class;
                break; }
            }

            if($nextClass){
                $formatted_date = date('l, F j, Y', strtotime($nextClass['Session_Date']));

                echo 
                '
                <div class="next-class-section">
                    <div>
                        <p class="next-class-p">'.htmlspecialchars($nextClass['Session_Type']).' with '.htmlspecialchars($nextClass['Trainer_Name']).'</p>
                        <p class="date-and-time">'.$formatted_date.'</p>
                    </div>
                    <div class="img-container next-class-container"><img src="../../../Assets//customer-dashboard-assets/session-marker-assets/'.htmlspecialchars($nextClass['Session_Type']).'.jpg" alt="class-img" class="next-class-img">
                    </div>
                </div>
                ';
            }
            elseif(!$nextClass) {
                echo 
                '
                <div class="next-class-section not">
                    <div>
                        <p class="next-class-p">No upcoming classes scheduled.</p>
                    </div>
                </div>
                ';
            }           
        ?>

        <h3 class="your-membership-header overview-subheaders section-subheader">Your Membership</h3>

        <?php
            $fetch_query = "SELECT memberships.Plan_Type, memberships.Status, memberships.Expiry_Date from memberships JOIN trainers ON trainers.Trainer_ID = memberships.Trainer_ID WHERE memberships.User_ID = '".$_SESSION['user_id']."'";

            $result = $conn->query($fetch_query);
            $row = $result->fetch_assoc();
            if($row){
            $_SESSION['card'] = $row['Status'];
            if($row['Status'] == 'Approved'){
                echo '
                <div class="your-membership-section">
                    <div>
                        <p class="your-membership-p">'.htmlspecialchars($row['Plan_Type']).' Membership</p>
                        <p class="expiry-date">Expires on '.htmlspecialchars($row['Expiry_Date']).'</p>
                    </div>
                    <div class="img-container membership-card '.htmlspecialchars($row['Plan_Type']).'-card">
                        <h1 class="membership-plan '.htmlspecialchars($row['Plan_Type']).'-title">
                            '.htmlspecialchars($row['Plan_Type']).'
                        </h1> 
                    </div>
                </div>';
            }

            elseif($row['Status'] == 'Not Approved'){
                echo 
                '
                <div class="your-membership-section">
                    <div>
                        <p class="your-membership-p">Has Not Been Approved Yet.</p>
                    </div>
                    <div class="img-container membership-card" style="box-shadow: none;"></div>
                </div>
                ';
            }
        }
        else{
            echo 
                '
                <div class="your-membership-section">
                    <div>
                        <p class="your-membership-p">Has Not Been Approved Yet.</p>
                    </div>
                    <div class="img-container membership-card" style="box-shadow: none;"></div>
                </div>
                ';
        }
            $result->free();
        ?>

        <h3 class="recent-activity-header overview-subheaders section-subheader">Recent Activity</h3>

        <?php
            $activity_result->data_seek(0);
            while($recents = $activity_result->fetch_assoc()){
                if($recents['Status'] == 'completed'){
                    echo
                    '
                    <p class="recent-activities">Completed: '.htmlspecialchars($recents['Session_Type']).' with '.htmlspecialchars($recents['Trainer_Name']).'</p>
                    <p class="activity-date">'.date('l, F j, Y', strtotime($recents['Session_Date'])).'</p>
                    ';
                }
                if($recents['Status'] == 'pending'){
                    echo
                    '
                    <p class="recent-activities">Booked: '.htmlspecialchars($recents['Session_Type']).' with '.htmlspecialchars($recents['Trainer_Name']).'</p>
                    <p class="activity-date">'.date('l, F j, Y', strtotime($recents['Session_Date'])).'</p>
                    ';
                }
            }
            $activity_result->free();
            $conn->close();
        ?>

        
    </section>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>