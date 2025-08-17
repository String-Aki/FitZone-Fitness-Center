<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
    
    <?php include("../components/staff-dashboard-side-bar.php");?>

    <main>

    <?php include("../components/staff-dashboard-header.php");?>

      <section class="staff-dashboard-section">

      

        <div class="bento-grid">
          <div class="card span-1 approval-card ">
            <div class="card-header">
              <h3 class="card-title">Approvals</h3>
              <i class="fa-solid fa-ellipsis more-button card-menu-icon"></i>
            </div>
            <div class="approval-space">
              <?php 
                $fetch_approval = "SELECT Membership_ID, memberships.User_ID, Plan_Type, Requested_Date, Status, users.Profile_Img_Path, users.First_Name, users.Last_Name FROM memberships JOIN users ON memberships.User_ID = users.User_ID WHERE Status = 'NOT Approved'";

                $memberships = $conn->query($fetch_approval);
                if($memberships->num_rows > 0)
                {
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
                  '<div class="approval-item">
                  <div class="approval-content-wrapper">
                  <p>No new approvals</p>
                  </div>
                  </div>';
                }
              ?>
            </div>
          </div>

          <div class="card span-2 appointment-card">
            <div class="card-header">
              <h3 class="card-title">Appointments</h3>
              <i class="fa-solid fa-ellipsis more-button card-menu-icon"></i>
            </div>

            <div class="appointment-space">
              <div class="appointment-item item">
                <div class="profile-container">
                    <img
                      alt="Profile Image"
                      class="avatar"
                      src="../../Assets/customer-dashboard-assets/profile.png"
                    />
                </div>
                <div class="appointment-content-wrapper">
                  <div class="appointment-content">
                    <p>Sarah Connor Requests For Spin Session</p>
                    <p>Monday, August 4, 2025</p>
                  </div>
                </div>
                <i class="fa-solid fa-caret-down show-more"></i>
              </div>
            </div>
          </div>

          <div class="card span-2 message-card">
            <div class="card-header">
              <h3 class="card-title">Notifications</h3>
              <i class="fa-solid fa-ellipsis more-button card-menu-icon"></i>
            </div>

            <div class="message-space">
              <div class="message-item">
                <div class="profile-container">
                    <img
                      alt="Profile Image"
                      class="avatar"
                      src="../../Assets/customer-dashboard-assets/profile.png"
                    />
                </div>
                <div class="message-content-wrapper">
                  <div class="message-content">
                    <p>Sarah Connor</p>
                    <p>Hi, can I reschedule my appointment for tomorrow?</p>
                  </div>
                </div>
                <p class="message-timestamp">10:45 AM</p>
              </div>
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
                <span class="task-count">3</span>
              </div>
              <div class="task-item">
                <div class="task-details">
                  <i class="fa-solid fa-clock-rotate-left task-icon"></i>
                  <span class="task-name">Pending Appointments</span>
                </div>
                <span class="task-count">5</span>
              </div>
              <div class="task-item">
                <div class="task-details">
                  <i
                    class="fa-solid fa-circle-question task-icon"
                    style="color: #ff0000"
                  ></i>
                  <span class="task-name">Unresolved Queries</span>
                </div>
                <span class="task-count">8</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
