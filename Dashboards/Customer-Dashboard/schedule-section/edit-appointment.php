<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Edit Appointment</title>
</head>
<body>
    <?php
        include("../../components/customer-dashboard-navbar.php");
    ?>
    <section class="dashboard-sections edit">
        <i onclick = 'window.location.href="./manage-appointment.php"' class="fas fa-arrow-left back"></i>
        <h1 class="headers">Edit Booking</h1>

        <?php
            if(isset($_GET['edit_id'])){
                $edit_id = $_GET['edit_id'];

                $fetch_query = "SELECT appointments.Appointment_ID, appointments.User_ID, appointments.Session_Type, appointments.Session_Date, appointments.Session_Time, trainers.Trainer_ID FROM appointments JOIN trainers ON appointments.Trainer_ID = trainers.Trainer_ID WHERE appointments.Appointment_ID = '$edit_id' AND appointments.User_ID = '". $_SESSION['user_id'] ."'"; 

            $results = $conn->query($fetch_query);
            $edit_row =  $results->fetch_assoc();
        }
        ?>
        <form action="" method="post" class="appointment-form all-forms edit ">
            <label for="trainer-field">Select Trainer</label>
            <select name="trainer" id="trainer-field">
                <option value="">-- Pick Your Trainer --</option>

                <?php
                    $query = "SELECT Trainer_ID, Name FROM trainers";
                    $results = $conn->query($query);

                    if($results-> num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            $picked = (($row['Trainer_ID'] === $edit_row['Trainer_ID']) ? 'selected' : '');
                            echo "<option value='" . $row['Trainer_ID'] . "' $picked>" . htmlspecialchars($row['Name']) . "</option>";
                        }
                    }

                    else {
                        echo "<option value=''>No Trainers Available</option>";
                    }
                    $results->free();
                    $conn->close();
                ?>
            </select>

            <label for="training-session-type-field" class="training-session-type-label">Training Session Type</label>
            <select name="training-session-type" id="training-session-type-field" required>
                <option value="">-- Choose Session Type --</option>
                <?php
                    $session_type_array = [
                        'Strength Training' => 'Strength Training',
                        'Cardio' => 'Cardio Workouts',
                        'Yoga' => 'Yoga',
                        'Pilates' => 'Pilates',
                        'HIIT' => 'High-Intensity Interval Training (HIIT)',
                        'Spin' => 'Spin Classes',
                        'Personal Training' => 'Personal Training Sessions'
                    ];

                    foreach($session_type_array as $value => $label){
                        echo '<option value="' . htmlspecialchars($value) . '" ' . ($edit_row['Session_Type'] === $value ? 'selected' : '') . '>' . htmlspecialchars($label) . '</option>';
                    }
                ?>
            </select>

            <label for="session-date">Session Date</label>
            <input type="date" name="session-date" id="session-date" value="<?php echo $edit_row['Session_Date']?>" >

            <label for="session-time">Session Time</label>
            <input type="time" name="session-time" id="session-time" value="<?php echo $edit_row['Session_Time']?>">

            <div class="button-wrap">
                <button type="submit" class="save-button" name="save">Save Changes</button>
                <button onclick="return confirm('Confirm to cancel this booking');" type="submit" class="delete-button" name="del">Cancel Appointment</button>
            </div>
        </form>
    </section>

    <?php
    // Update And Delete Appointment 
        if(isset($_POST['save'])){
            $trainer_id = $_POST['trainer'];
            $session_type = $_POST['training-session-type'];
            $session_date = $_POST['session-date'];
            $session_time = $_POST['session-time'];

            $sqlUpdate = "UPDATE appointments SET Trainer_ID = '$trainer_id', Session_Type = '$session_type', Session_Date = '$session_date', Session_Time = '$session_time' WHERE Appointment_ID = '$edit_id' AND appointments.User_ID = '".$_SESSION['user_id']."'";

            if($conn->query($sqlUpdate) === TRUE){
                echo '<script type="text/javascript">alert("Booking Changes Saved");
            window.location.href="./manage-appointment.php";
            </script>';
            }
            else {
                echo '<script type="text/javascript">alert("Failed to Save Changes");
                </script>';
            }
        }

        elseif(isset($_POST['del'])){
            $sqlDelete = "DELETE FROM appointments WHERE Appointment_ID = '$edit_id' AND User_ID = '".$_SESSION['user_id']."'";

            if($conn->query($sqlDelete) === TRUE){
                echo '<script type="text/javascript">alert("Booking Cancelled Successfully");
            window.location.href="./manage-appointment.php";
            </script>';
            }

            else {
                echo '<script type="text/javascript">alert("Failed to Cancelled Booking");
                </script>';
            }
        }
        $conn->close();

    ?>

    <script src="https://kit.fontawesome.com/15767cca17.js" crossorigin="anonymous"></script>
</body>
</html>