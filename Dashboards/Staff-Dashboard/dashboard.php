<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
    
    <?php 
    session_start();
    include("../../includes/dbconnect.php");
    error_reporting(0);
    
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

    <?php 
    include("../components/staff-dashboard-header.php");
    

if($_SERVER['REQUEST_METHOD'] === 'POST'){
// Membership Handling
  if(isset($_POST['approve'])){
    $membership_id = $_POST['membership_id'];
    $status = "Approved";
    $approved_Date = date('Y-m-d');
    $expiry_date = date('Y-m-d', strtotime('+1 month'));
    
    $stmt=$conn->prepare("UPDATE memberships SET Status = ?, Approved_Date = ?, Expiry_Date = ? WHERE memberships.Membership_ID = ?");
    
    $stmt->bind_param("sssi", $status, $approved_Date, $expiry_date, $membership_id);
    
    if($stmt->execute()){
      echo 
      '
      <script>
      alert("Approved!");
      document.getElementById("$dialogID").close();
      </script>';
    }
    else{
      echo "<script>alert('Error approving membership.');</script>";
    }
    $stmt->close();
  }
  elseif(isset($_POST['dis-approve'])){
    $membership_id = $_POST['membership_id'];
    $remove_membership = $conn->prepare("DELETE FROM memberships WHERE Membership_ID = ?");

    $remove_membership->bind_param("i",$membership_id);

    if($remove_membership->execute()){
    echo 
    '
    <script>
    alert("Membership declined");
    document.getElementById("$dialogID").close();
    </script>';
    }
    else{
    echo "<script>alert('Error declining membership.');</script>";
    }
    $remove_membership->close();
  }

  // Appointment Handling
  
  if(isset($_POST['confirm'])){
    $appointment_id = trim($_POST['appointment_id']);

    $update_appointment = $conn->query("UPDATE appointments SET Status = 'confirmed' WHERE Appointment_ID = '".$appointment_id."'");

    if($update_appointment){
      echo 
      '
      <script>
      alert("Appointment Confirmed");
      document.getElementById("$dialogID").close();
      </script>';
    }
    else{
      echo "<script>alert('Error confirming appointment.');</script>";
    }
    }
    elseif(isset($_POST['cancel'])){
      $appointment_id = trim($_POST['appointment_id']);
      
      $update_appointment = $conn->query("UPDATE appointments SET Status = 'cancelled' WHERE Appointment_ID = '".$appointment_id."'");

      if($update_appointment){
      echo 
      '
      <script>
      alert("Appointment Cancelled");
      document.getElementById("$dialogID").close();
      </script>';
    }
    else{
      echo "<script>alert('Error cancelling appointment.');</script>";
    }
    }

    // Message Handling

    if(isset($_POST['reply'])){
      $message_id = trim($_POST['message_id']);
      $reply_message = trim($_POST['reply-message']);

      $send_reply = "UPDATE messages SET Response = ?, Status = 'responded' WHERE Message_ID = '".$message_id."'";

      $reply = $conn->prepare($send_reply);

      $reply->bind_param("s", $reply_message);

      if($reply->execute())
        {
        echo 
      '
      <script>
      alert("Reply Sent Successfully");
      document.getElementById("$dialogID").close();
      </script>';
      }
    
    else
      {
      echo "<script>alert('Error sending reply.');</script>";
      }
      }
    }

    ?>

      <section class="staff-dashboard-section">      
        <div class="bento-grid">
          <div class="card span-1 approval-card ">
            <div class="card-header">
              <h3 class="card-title">Approvals</h3>
            </div>
            <div class="approval-space">
              <?php 
                $fetch_approval = "SELECT Membership_ID, memberships.User_ID, Plan_Type, Requested_Date, Status, users.Profile_Img_Path, users.First_Name, users.Last_Name FROM memberships JOIN users ON memberships.User_ID = users.User_ID WHERE Status = 'NOT Approved'";

                $memberships = $conn->query($fetch_approval);

                
                if($memberships->num_rows > 0)
                  {
                  $membership_task_summary = $memberships->num_rows;
                  while($request = $memberships->fetch_assoc()){
                    if (substr($request['Profile_Img_Path'], 0, 3) === '../') {
                      $correct_path = substr($request['Profile_Img_Path'], 3);
                    }
                    else {
                      $correct_path = "../../Assets/customer-dashboard-assets/profile.png";
                    }
                    
                  $dialogID = "approval-popup" . htmlspecialchars($request['Membership_ID']);
                  $For_Month = date('F', strtotime($request['Requested_Date']));

                  $pfp_path = (!empty($request['Profile_Img_Path'])) ? $correct_path : "../../Assets/customer-dashboard-assets/profile.png";

                  echo
                  '
              <div class="approval-item item">
                <div class="approval-item-profile">
                  <img
                    alt="Profile Image "
                    class="avatar"
                    src="'.htmlspecialchars($pfp_path).'"
                  />
                </div>
                <div class="approval-content-wrapper">
                  <div class="approval-content">
                    <p>'.htmlspecialchars($request['First_Name']." ".$request['Last_Name']).' Membership Approval</p>
                    <p class="review" onclick="document.getElementById(\''.$dialogID.'\').showModal();">Review</p>
                  </div>
                </div>
              </div>

              <dialog id="' . $dialogID . '" class="modal-view">
                <div class="inner-wrapper">
                    <div class="header-wrapper">
                        <div class="profile-wrapper">
                            <div class="profile-container">
                                <img class="avatar" src="' . htmlspecialchars($pfp_path) . '" alt="profile-img" />
                            </div>
                            <p class="user-name">' . htmlspecialchars($request['First_Name'] . " " . $request['Last_Name']). '</p>
                        </div>
                        <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\'' . htmlspecialchars($dialogID) . '\').close();"></i>
                    </div>
                    <div class="content">
                        <h1 class="topic plan-type">Plan Type</h1>
                        <div class="img-container membership-card ' . htmlspecialchars($request['Plan_Type']) . '-card card-align">
                            <h1 class="membership-plan ' . htmlspecialchars($request['Plan_Type']) . '-title">' . htmlspecialchars($request['Plan_Type']) . '</h1>
                        </div>
                        <p class="messages-content">
                            <strong class="message-header">For the Month of : '.htmlspecialchars($For_Month).'</strong>
                        </p>
                        <form method="post" class="appointment-action-form">
                            <input type="hidden" name="membership_id" value="' . htmlspecialchars($request['Membership_ID']) . '">
                            <button type="submit" name="approve" class="confirm-button reply-button">approve</button>
                            <button type="submit" name="dis-approve" class="decline-button reply-button">decline</button>
                        </form>
                    </div>
                </div>
            </dialog>
                  ';
                  }}
                else{
                  echo
                  '<div>
                  <div class="approval-content-wrapper">
                  <p>No new approvals</p>
                  </div>
                  </div>';
                  $membership_task_summary = 0;
                }
                $memberships->close();
              ?>
            </div>
          </div>

          <div class="card span-2 appointment-card">
            <div class="card-header">
              <h3 class="card-title">Appointments</h3>
              <i class="fa-solid fa-ellipsis more-button appointments card-menu-icon"></i>
            </div>
            <div class="appointment-space">
            <?php
              $fetch_appointments = "SELECT appointments.*,users.First_Name, users.Last_Name, users.Profile_Img_Path FROM appointments JOIN users on appointments.User_ID = users.User_ID JOIN trainers on appointments.Trainer_ID = trainers.Trainer_ID WHERE trainers.User_ID = '".$UID."' AND appointments.Status = 'pending'";

              $appointments = $conn->query($fetch_appointments);

              if($appointments->num_rows > 0){

                $appointment_task_summary = $appointments->num_rows;

                while($available_appointments = $appointments->fetch_assoc()){
                  if (substr($available_appointments['Profile_Img_Path'], 0, 3) === '../') {
                      $path = substr($available_appointments['Profile_Img_Path'], 3);
                    }
                    else {
                      $path = "../../Assets/customer-dashboard-assets/profile.png";
                    }

                    $pfp_path_for_appointments = (!empty($available_appointments['Profile_Img_Path'])) ? $path : "../../Assets/customer-dashboard-assets/profile.png";

                    $appointment_date = date('l, F j, Y', strtotime($available_appointments['Session_Date']));
                    $appointment_day_Month = date('l, F j', strtotime($available_appointments['Session_Date']));
                    $appointment_time = date('g.i a', strtotime($available_appointments['Session_Time']));
                    $appointment_Datetime = date('l, F j, Y \a\t g:i a', strtotime($available_appointments['Session_Time']));
                    $booked_time = date('F d, g.i a', strtotime($available_appointments['created_at']));

                    $appointment_dialogID = "appointment-popup" . htmlspecialchars($available_appointments['Appointment_ID']);

                    echo 
                    '
                    <div class="appointment-item item" onclick="document.getElementById(\''.$appointment_dialogID.'\').showModal();">
                <div class="profile-container">
                    <img
                      alt="Profile Image"
                      class="avatar"
                      src="'.htmlspecialchars($pfp_path_for_appointments).'"
                    />
                </div>
                <div class="appointment-content-wrapper">
                  <div class="appointment-content">
                    <p>'.htmlspecialchars($available_appointments['First_Name']." ".$available_appointments['Last_Name']).' Requests For '.htmlspecialchars($available_appointments['Session_Type']).' Session</p>
                    <p>'.htmlspecialchars($appointment_date).'</p>
                  </div>
                </div>
                <i class="fa-solid fa-caret-down show-more"></i>
              </div>


      <dialog id="' . $appointment_dialogID . '" class="modal-view appointment-view">
      <div class="inner-wrapper">
        <div class="header-wrapper">
          <div class="profile-wrapper">
            <div class="profile-container">
              <img
                class="avatar"
                src="'.htmlspecialchars($pfp_path_for_appointments).'"
                alt="profile-img"
              />
            </div>
            <p class="user-name">'.htmlspecialchars($available_appointments['First_Name']." ".$available_appointments['Last_Name']).'</p>
          </div>
          <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\'' . htmlspecialchars($appointment_dialogID) . '\').close();"></i>
        </div>

        <div class="content">
          <h1 class="topic session-type">'.htmlspecialchars($available_appointments['Session_Type']).'</h1>
          <p class="messages-content appointments-content">
            <strong class="message-header date-and-time">The Appointment is on:</strong>
            <br />'.htmlspecialchars($appointment_Datetime).'
          </p>
          <p class="time-received">
            Booked on: '.htmlspecialchars($booked_time).'
          </p>
          <form method="post" class="appointment-action-form">
            <input type="hidden" name="appointment_id" value="' . htmlspecialchars($available_appointments['Appointment_ID']) . '">
            <button type="submit" name="confirm" class="confirm-button reply-button">Confirm</button>
            <button type="submit" name="cancel" class="decline-button reply-button">Cancel</button>
          </form>
        </div>
      </div>
    </dialog>';
                }
              }
              else 
              {
                echo
                '
                <div>
                  <div class="appointment-content-wrapper">
                    <p>No new appointments</p>
                  </div>
                </div>
                ';
                $appointment_task_summary = 0;
              }
            ?>
            </div>
          </div>

          <div class="card span-2 message-card">
            <div class="card-header">
              <h3 class="card-title">Notifications</h3>
              <i class="fa-solid fa-ellipsis more-button messages card-menu-icon"></i>
            </div>

            <div class="message-space">

            <?php
              $fetch_messages = "SELECT messages.Message_ID, messages.Topic, messages.Message, messages.Created_At, users.First_Name, users.Last_Name, users.Profile_Img_Path FROM messages JOIN users ON messages.User_ID = users.User_ID JOIN trainers ON messages.Recipient_ID = trainers.Trainer_ID WHERE trainers.User_ID = '".$UID."' AND messages.Status = 'pending'";

              $messages = $conn->query($fetch_messages);

              
              if($messages->num_rows > 0 ){
                $message_task_summary = $messages->num_rows;

                while($received_messages = $messages->fetch_assoc()){

                  if (substr($received_messages['Profile_Img_Path'], 0, 3) === '../') {
                      $mpath = substr($received_messages['Profile_Img_Path'], 3);
                    }
                    else {
                      $mpath = "../../Assets/customer-dashboard-assets/profile.png";
                    }

                    $pfp_path_for_messages = (!empty($received_messages['Profile_Img_Path'])) ? $mpath : "../../Assets/customer-dashboard-assets/profile.png";

                    $message_dialogID = "appointment-popup" . htmlspecialchars($received_messages['Message_ID']);

                    $sent_time = date('M j, g:i a', strtotime($received_messages['Created_At']));
                    $sent_time_full = date('F j, Y \a\t g:i a', strtotime($received_messages['Created_At']));

                    echo
                    '
                    <div class="message-item" onclick="document.getElementById(\''.$message_dialogID.'\').showModal();">
                <div class="profile-container">
                    <img
                      alt="Profile Image"
                      class="avatar"
                      src="'.htmlspecialchars($pfp_path_for_messages).'"
                    />
                </div>
                <div class="message-content-wrapper">
                  <div class="message-content">
                    <p>'.htmlspecialchars($received_messages['First_Name']." ".$received_messages['Last_Name']).'</p>
                    <p>'.htmlspecialchars($received_messages['Topic']).'</p>
                  </div>
                </div>
                <p class="message-timestamp">'.htmlspecialchars($sent_time).'</p>
              </div>

               <dialog id="' . $message_dialogID . '" class="modal-view">
      <div class="inner-wrapper">
        <div class="header-wrapper">
          <div class="profile-wrapper">
            <div class="profile-container">
              <img
                class="avatar"
                src="'.htmlspecialchars($pfp_path_for_messages).'"
                alt="profile-img"
              />
            </div>
            <p class="user-name">'.htmlspecialchars($received_messages['First_Name']." ".$received_messages['Last_Name']).'</p>
          </div>
          <i class="fas fa-circle-xmark close-button" onclick="document.getElementById(\'' . htmlspecialchars($message_dialogID) . '\').close();"></i>
        </div>

        <div class="content">
          <h1 class="topic">'.htmlspecialchars($received_messages['Topic']).'</h1>
          <p class="messages-content">
            <strong class="message-header">Inquiry:</strong>
            <br />'.htmlspecialchars($received_messages['Message']).'
          </p>
          <p class="time-received">
            '.htmlspecialchars($sent_time_full).'
          </p>
          <form method="post" class="reply-form">
            <input type="hidden" name="message_id" value="' . htmlspecialchars($received_messages['Message_ID']) . '">
            <label for="response">Response</label>
            <textarea name="reply-message" id="response" rows="5" class="reply-field"></textarea>
            <button type="submit" name="reply" class="reply-button">Reply</button>
          </form>
        </div>
      </div>
    </dialog>';
                }
              }
              else
              {
                echo
                '
                <div>
                  <div class="message-content-wrapper">
                      <div class="message-content">
                        <p>No new messages</p>
                      </div>
                  </div>
                </div>
                ';
                $message_task_summary = 0;
              }
            ?>
            </div>
          </div>

          <div class="card span-1 task-summary">
            <div class="card-header">
              <h3 class="card-title">Task Summary</h3>
            </div>

            <div class="tasks-container">
              <div class="task-item item">
                <div class="task-details">
                  <i
                    class="fa-solid fa-circle-check task-icon"
                    style="color: #63e6be"
                  ></i>
                  <span class="task-name">Membership Approvals</span>
                </div>
                <span class="task-count"><?php echo htmlspecialchars($membership_task_summary)?></span>
              </div>
              <div class="task-item">
                <div class="task-details">
                  <i class="fa-solid fa-clock-rotate-left task-icon"></i>
                  <span class="task-name">Pending Appointments</span>
                </div>
                <span class="task-count"><?php echo htmlspecialchars($appointment_task_summary)?></span>
              </div>
              <div class="task-item">
                <div class="task-details">
                  <i
                    class="fa-solid fa-circle-question task-icon"
                    style="color: #ff0000"
                  ></i>
                  <span class="task-name">Unresolved Queries</span>
                </div>
                <span class="task-count"><?php echo htmlspecialchars($message_task_summary)?></span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    
    <script>
      const moreButton = document.querySelectorAll(".more-button");

      moreButton.forEach(button =>{
        button.addEventListener("click", ()=>{
          if(button.classList.contains("appointments")){
            window.location.href = "./appointments.php?uid=<?php echo htmlspecialchars($UID)?>";
          }
          else
            {
            window.location.href = "./messages.php?uid=<?php echo htmlspecialchars($UID)?>";
          }

        });
      })
    </script>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
