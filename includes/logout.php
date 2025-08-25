<?php
session_start();
$uid_to_logout = $_GET['uid'] ?? null;
$role_to_logout = $_GET['role'] ?? null;

if($uid_to_logout && $role_to_logout && isset($_SESSION['auth'][$role_to_logout][$uid_to_logout])){
    unset($_SESSION['auth'][$role_to_logout][$uid_to_logout]);
}

echo '<script>
    alert("Logging You Out...");
    window.location.href = "../index.php";
</script>';
exit;
?>
