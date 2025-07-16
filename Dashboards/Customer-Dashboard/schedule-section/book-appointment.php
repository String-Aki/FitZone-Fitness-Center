<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Book Appointment</title>
</head>
<body>
    <nav class="customer-dashboard-navbar">
        <div class="branding">
            <i class="fas fa-dumbbell logo"></i>
            <span class="logo-header">FitZone</span>
        </div>

        <div class="links-and-profile-container">
            <div class="links">
                <a href="../overview-section/dashboard-overview.php" class="nav-link">Overview</a>
                <a href="./book-appointment.php" class="nav-link">Schedule</a>
                <a href="" class="nav-link">Nutrition</a>
                <a href="" class="nav-link">Contact</a>
            </div>
            <button class="profile-button" onclick=""><img  src="../../../Assets/customer-dashboard-assets/profile.png" alt="profile-img" class="profile-img"></button>
        </div>
    </nav>

    <section class="book-appointment dashboard-sections">
        <h1 class="headers">My Schedule</h1>
        <div class="Schedule-indicator indicator-div">
                <div class="manage-schedule">
                    <h2 onclick="window.location.href = './book-appointment.php'" class="book-appointment sub-header">Book Appointment</h2>
                    <h2 onclick="window.location.href = './manage-appointment.php'" class="manage-appointment sub-header" style="color:#637587;">Manage Appointment</h2>
                </div>
            </div>
            <hr class="line">
        </div>

        <h3 class="section-subheader request-class">Request a Class</h3>
        <form action="" class="book-appointment-form">
            <label for="trainer-field">Select Trainer</label>
            <select name="trainer" id="trainer-field">
                <option value="">-- Pick Your Trainer --</option>
            </select>

            <label for="training-session-type-field" class="training-session-type-label">Training Session Type</label>
            <select name="training-session-type" id="training-session-type-field" required>
                <option value="">-- Choose Session Type --</option>
            </select>

            <label for="session-date">Session Date</label>
            <input type="date" name="session-date" id="session-date">

            <label for="session-time">Session Time</label>
            <input type="time" name="session-time" id="session-time">

            <button type="submit" class="submit-button">Submit Request</button>
        </form>
    </section>

    <script type="module" src="./script.js"></script>
</body>
</html>