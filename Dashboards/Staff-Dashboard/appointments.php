<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Appointments</title>
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
    
    <?php
    include("../components/staff-dashboard-side-bar.php");?>

    <main>
      
      <?php include("../components/staff-dashboard-header.php");
      
        if($_SERVER['REQUEST_METHOD'] === 'GET'){

          if(isset($_GET['completed'])){
            $appointment_id = trim($_GET['appointment_id']);

            $update_appointment = $conn->query("UPDATE appointments SET Status = 'completed' WHERE Appointment_ID = '".$appointment_id."'");

           if($update_appointment){
            echo 
            '
            <script>
            alert("Appointment Completed");
            window.location.href = "./appointments.php?header_title=Appointments";
            </script>';
          }
          else{
            echo "<script>alert('An error occured');</script>";
          }

          }
          elseif(isset($_GET['cancelled'])){

            $appointment_id = trim($_GET['appointment_id']);

            $update_appointment = $conn->query("UPDATE appointments SET Status = 'cancelled' WHERE Appointment_ID = '".$appointment_id."'");

           if($update_appointment){
            echo 
            '
            <script>
            alert("Appointment Cancelled");
            window.location.href = "./appointments.php?header_title=Appointments";
            </script>';
          }
          else{
            echo "<script>alert('An error occured');</script>";
          }

          }
        }
      ?>

      <section class="staff-dashboard-section">
        
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Appointment ID</th>
                <th>Full Name</th>
                <th>Session Type</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Booked On</th>
                <th style="text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>

            <?php
              $fetch_appointments = "SELECT appointments.*, users.First_Name, users.Last_Name,users.Phone FROM appointments JOIN users ON appointments.User_ID = users.User_ID JOIN trainers ON appointments.Trainer_ID = trainers.Trainer_ID WHERE trainers.User_ID = '".$_SESSION['user_id']."' AND appointments.Status = 'confirmed'";

              $appointments = $conn->query($fetch_appointments);

              if($appointments->num_rows > 0){

                while($row = $appointments->fetch_assoc()){

                  $Session_Date_Formatted =date('m-d-Y', strtotime($row['Session_Date']));
                  $Session_Time_Formatted =date('g.i a', strtotime($row['Session_Time']));
                  $Booked_Date_Formatted =date('m-d-Y g:i A', strtotime($row['created_at']));

                  echo 
                  '
                  <tr>
                <td>#'.htmlspecialchars($row['Appointment_ID']).'</td>
                <td class="full-name">'.htmlspecialchars($row['First_Name']." ".$row['Last_Name']).'</td>
                <td>
                  '.htmlspecialchars($row['Session_Type']).'
                </td>
                <td>'.htmlspecialchars($row['Phone']).'</td>
                <td>'.htmlspecialchars($Session_Date_Formatted).'</td>
                <td>'.htmlspecialchars($Session_Time_Formatted).'</td>
                <td>'.htmlspecialchars($Booked_Date_Formatted).'</td>
                <td class="actions">
                  <form action="" method="GET" id="ap_form" class="actions">
                  <input name="appointment_id" value="'.htmlspecialchars($row['Appointment_ID']).'" type="hidden" />
                  <button class="action-links completed" name="completed" type="submit" ">Completed</button> | <button class="action-links cancelled" name="cancelled" type="submit">Cancelled</button>
                  </form>
                </td>
              </tr>
                  ';

                }
              }
              else
              { echo
                  '<tr>
                    <td colspan="8" style="text-align:center; font-size:1.5vw; font-weight:500;">No new appointments</td>
                  </tr>';
              }
            ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </body>
</html>
