<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Membership</title>
    <link rel="stylesheet" href="../style.css" />
  </head>
  <body>

    <?php include("../../components/customer-dashboard-navbar.php"); ?>

    <?php
      $fetch_query = "SELECT Plan_Type, Status, Expiry_Date FROM memberships WHERE User_ID = '".$_SESSION['user_id']."'";

      $fetch = $conn->query($fetch_query);
      $result = $fetch->fetch_assoc();
    ?>
    <section class="dashboard-sections">
      <h1 class="headers">Membership Details</h1>
      <div class="indicator-div">
        <h2 class="sub-header color">
          Manage your FitZone membership, explore benefits, and renew your plan.
        </h2>
      </div>
      <hr class="line" />
      <h3 class="section-subheader">Current Plan</h3>

      <div class="your-membership-section">
        <div>
          <p class="your-membership-p">
            <?php echo $result && $result['Status'] == 'Approved' ? htmlspecialchars($result['Plan_Type'])." Plan" : "Membership Has Not Been Approved Yet.";?>
          </p>
          <p class="expiry-date">
            <?php echo $result && $result['Status'] == 'Approved' ? "Expirys on ".htmlspecialchars($result['Expiry_Date']) : "";?>
          </p>
        </div>
        <div
          class="img-container membership-card <?php echo $result && $result['Status'] == 'Approved' ? htmlspecialchars($result['Plan_Type'])."-card" : "";?>" style="<?php echo $result && $result['Status'] == 'Approved' ? "display:flex" : "display:none";?>"
        >
          <h1
            class="membership-plan <?php echo htmlspecialchars($result['Plan_Type'])?>-title"
          >
            <?php echo htmlspecialchars($result['Plan_Type'])?>
          </h1>
        </div>
      </div>
      
      <h3 class="section-subheader">Membership Benefits</h3>
      <div class="membership-benefits">

        <div class="benefits-box">
            <i class="fas fa-dumbbell"></i>
            <p class="benefit-info">Unlimited Workouts</p>
        </div>
        <div class="benefits-box">
            <i class="fas fa-heart"></i>
            <p class="benefit-info">Personalized Training</p>
        </div>
        <div class="benefits-box">
            <i class="fas fa-people-group"></i>
            <p class="benefit-info">Community Access</p>
        </div>
        <div class="benefits-box">
            <i class="fas fa-calendar-days"></i>
            <p class="benefit-info">Exclusive Events</p>
        </div>
      </div>

      <h3 class="section-subheader">Membership Options</h3>
      <div class="plans-container">
        <div class="plan-box">
          <h1 class="plan-type">Basic</h1>
          <h2 class="price">Rs.2290<span class="per-month">/month</span></h2>
          <form action="" method="post" class="plan-form"><button class="choose-plan" name="plan" value="basic" type="submit">Choose Plan</button></form>
          <ul class="perks-list">
            <li class="perks">Gym floor and basic equipment access</li>
            <li class="perks">Locker room and mobile app access</li>
          </ul>
        </div>
        <div class="plan-box">
          <h1 class="plan-type">Pro</h1>
          <h2 class="price">Rs.3290<span class="per-month">/month</span></h2>
          <form action="" method="post" class="plan-form"><button class="choose-plan" name="plan" value="pro" type="submit">Choose Plan</button></form>
          <ul class="perks-list">
            <li class="perks">All Basic features</li>
            <li class="perks">Group classes</li>
            <li class="perks">personal trainer consultation</li>
            <li class="perks">Nutrition guidance</li>
          </ul>
        </div>
        <div class="plan-box">
            <h1 class="plan-type">Elite</h1>
            <h2 class="price">Rs.4190<span class="per-month">/month</span></h2>
            <form action="" method="post" class="plan-form"><button class="choose-plan" name="plan" value="elite" type="submit">Choose Plan</button></form>
            <ul class="perks-list">
              <li class="perks">All Pro features</li>
              <li class="perks">Recovery zone </li>
              <li class="perks">Exclusive events</li>
              <li class="perks">VIP parking</li>
            </ul>
        </div>
      </div>
    </section>

    <?php
      if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $request_membership = "INSERT INTO memberships (User_ID, Plan_Type, Status, Requested_Date) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($request_membership);
        $status = 'Not Approved';
        $requested_date = date('Y-m-d');

        if($_POST['plan'] == 'basic'){
          $plan_type = 'Basic';
        }
        elseif($_POST['plan'] == 'pro'){
          $plan_type = 'Pro';
        }
        elseif ($_POST['plan'] == 'elite') {
          $plan_type = "Elite";
        }

        $stmt->bind_param("isss", $_SESSION['user_id'], $plan_type, $status, $requested_date);

        if($stmt->execute()){
          echo "<script>alert('$plan_type plan has been requested');</script>";
        }
        else
        {
          echo "<script>alert('Request Failed');</script>";
        }
        $stmt->close();
      }
      $conn->close();
    ?>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
