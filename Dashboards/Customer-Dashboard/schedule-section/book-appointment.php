<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Book Appointment</title>
</head>
<body>
    <?php include("../../components/customer-dashboard-navbar.php");?>

    <section class="book-appointment dashboard-sections">
        <h1 class="headers">My Schedule</h1>
        <div class="Schedule-indicator indicator-div">
                <div class="manage-schedule">
                    <h2 onclick="window.location.href = './book-appointment.php'" class="book-appointment sub-header">Book Appointment</h2>
                    <h2 onclick="window.location.href = './manage-appointment.php'" class="manage-appointment sub-header" style="color:#637587;">Manage Appointment</h2>
                </div>
            </div>
            <hr class="line">

        <h3 class="section-subheader request-class">Request a Class</h3>
        <form action="" method="post" class="appointment-form all-forms">
            <label for="trainer-field">Select Trainer</label>
            <select name="trainer" id="trainer-field">
                <option value="">-- Pick Your Trainer --</option>

                <?php
                    $query = "SELECT Trainer_ID, Name FROM trainers";
                    $results = $conn->query($query);

                    if($results-> num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            echo "<option value='" . $row['Trainer_ID'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
                        }
                    }

                    else {
                        echo "<option value=''>No Trainers Available</option>";
                    }
                    $results->free();
                ?>
            </select>

            <label for="training-session-type-field" class="training-session-type-label">Training Session Type</label>
            <select name="training-session-type" id="training-session-type-field" required>
                <option value="">-- Choose Session Type --</option>
                <option value="Strength Training">Strength Training</option>
                <option value="Cardio">Cardio Workouts</option>
                <option value="Yoga">Yoga</option>
                <option value="Pilates">Pilates</option>
                <option value="HIIT">High-Intensity Interval Training (HIIT)</option>
                <option value="Spin">Spin Classes</option>
                <option value="Personal Training">Personal Training Sessions</option>
            </select>

            <label for="session-date">Session Date</label>
            <input type="date" name="session-date" id="session-date" >

            <label for="session-time">Session Time</label>
            <input type="time" name="session-time" id="session-time">

            <button type="submit" class="submit-button" name="book">Submit Request</button>
        </form>
    </section>
                                    
    <?php
    if(isset($_POST['book'])){
        $user_id = $_SESSION['user_id'];
        $trainer_id = $_POST['trainer'];
        $session_type = $_POST['training-session-type'];
        $session_date = $_POST['session-date'];
        $session_time = $_POST['session-time'];
        $status = 'pending';
        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO appointments (User_ID, Trainer_ID, Session_Type, Session_Date, Session_Time, Status, created_at) VALUES('$user_id', '$trainer_id', '$session_type', '$session_date', '$session_time', '$status', '$created_at')";

        if($conn->query($sql) === TRUE){
            echo '<script type="text/javascript">alert("Session Booked Successfully");
        window.location.href="./manage-appointment.php";
        </script>';
        }
        else {
            echo '<script type="text/javascript">alert("Session Booking Failed");
            </script>';
        }
        $conn->close();
    }
    ?>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>