<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
     <?php
    session_start();
    include("../../includes/dbconnect.php");

    $UID = $_GET['uid'] ?? null;
    $current_user = NULL;

    if($UID && isset($_SESSION['auth']['admin'][$UID])){
        $current_user = $_SESSION['auth']['admin'][$UID];
    }

    if($current_user === NULL){
        header('Location: ../../Sign-In-Page/index.php');
        exit();
    }
     error_reporting(0);
     include("../components/admin/admin-menu.php")?>

    <section class="dashboard-selection">
        <ul class="selection-links">
            <li class="links"><a href="./create-account.php?selected=Create Account&uid=<?php echo htmlspecialchars($UID)?>">Create Account</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./manage-accounts.php?selected=Manage Accounts&uid=<?php echo htmlspecialchars($UID)?>">Manage Accounts</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./broadcast.php?selected=Broadcast&uid=<?php echo htmlspecialchars($UID)?>">Broadcast</a><i class="fas fa-arrow-right"></i></li>
            <li class="links"><a href="./Everything-Else/dashboard.php?uid=<?php echo htmlspecialchars($UID)?>">Everything Else</a><i class="fas fa-arrow-right"></i></li>
        </ul>
    </section>
</body>
</html>