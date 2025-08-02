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
        <div class="next-class-section">
            <div>
                <p class="next-class-p">Yoga Flow with Emily</p>
                <p class="date-and-time">Tuesday, July 23, 2024, 6:00 PM</p>
            </div>
            <div class="img-container"><img src="../../../Assets/customer-dashboard-assets/classes-img.png" alt="class-img" class="next-class-img"></div>
        </div>

        <h3 class="your-membership-header overview-subheaders section-subheader">Your Membership</h3>
        <div class="your-membership-section">
            <div>
                <p class="your-membership-p">Elite Membership</p>
                <p class="expiry-date">Expires on August 15, 2024</p>
            </div>
            <div class="img-container"><img src="../../../Assets/customer-dashboard-assets/memebership-card.png" alt="membership-img" class="membership-img"></div>
        </div>

        <h3 class="recent-activity-header overview-subheaders section-subheader">Recent Activity</h3>
        <div class="recent-activity-section">
            <p class="recent-activities">Completed: HIIT with Mark</p>
            <p class="activity-date">July 15, 2024</p>
            <p class="recent-activities">Booked: Yoga Flow with Emily</p>
            <p class="activity-date">Renewed: Elite Membership</p>
            <p class="recent-activities">Renewed: Premium Membership</p>
            <p class="activity-date">July 5, 2024</p>
        </div>
    </section>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>