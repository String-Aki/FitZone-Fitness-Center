<?php
session_start();
session_destroy();
echo '<script>
    alert("Logging You Out...");
    window.location.href = "../index.php";
</script>';
exit;
?>
