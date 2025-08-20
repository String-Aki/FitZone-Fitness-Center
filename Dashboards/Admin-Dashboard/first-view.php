<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
     <?php include("../components/admin/admin-menu.php")?>
    <section class="dashboard-selection">
        <ul class="selection-links">
            <li class="links"><a href="./create-account.php?selected=Create Account">Create Account</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./manage-accounts.php?selected=Manage Accounts">Manage Accounts</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./broadcast.php?selected=Broadcast">Broadcast</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./Everything-Else/dashboard.php">Everything Else</a><i class="fas fa-arrow-right"></i></li>
        </ul>
    </section>
</body>
</html>