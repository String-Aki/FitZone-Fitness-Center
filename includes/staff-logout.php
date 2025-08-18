<?php
include("./dbconnect.php");
$conn->close();
session_start();
session_destroy();
echo '<script>
    alert("Logging You Out...");
    window.location.href = "../index.php";
</script>';
exit;
?>
