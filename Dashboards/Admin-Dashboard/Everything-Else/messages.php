<?php 
session_start();
    include("../../../includes/dbconnect.php");

    $UID = $_GET['uid'] ?? null;
    $current_user = NULL;

    if($UID && isset($_SESSION['auth']['admin'][$UID])){
        $current_user = $_SESSION['auth']['admin'][$UID];
    }

    if($current_user === NULL){
        header('Location: ../../../Sign-In-Page/index.php');
        exit();
    }
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <?php include("../../components/admin/admin-dashboard-side-bar.php");?>
    
    <main>

    <?php include("../../components/admin/admin-dashboard-header.php");
    
        if(isset($_POST['close'])){
            $guest_id = $_POST['guest_id'];

            $update_query = "UPDATE contact_queries SET Status = 'closed' WHERE Guest_ID = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("i", $guest_id);

            if($stmt->execute()){
                echo
                '
                <script>
                alert("Query Closed");
                window.location.href = "./messages.php?uid='.htmlspecialchars($UID).'";
                </script>
                ';
            }
            else{
                echo
                '
                <script>
                alert("Failed to close query");
                window.location.href = "./messages.php?uid='.htmlspecialchars($UID).'";
                </script>
                ';
            }
        }
    ?>

        <section class="staff-dashboard-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Inquiry</th>
                            <th>Email</th>
                            <th>Phone_Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $fetch_messages = "SELECT * FROM contact_queries";

                        $messages = $conn->query($fetch_messages);
                        
                        if($messages->num_rows > 0 ){

                            while($row = $messages->fetch_assoc()){

                                $row['Status'] === 'closed'? ($is_closed=true) : ($is_closed=NULL);
                                echo 
                                '
                                <tr id="row-id-'.htmlspecialchars($row['Guest_ID']).'">
                            <td>#'.htmlspecialchars($row['Guest_ID']).'</td>
                            <td class="full-name">'.htmlspecialchars($row['Name']).'</td>
                            <td>'.htmlspecialchars($row['Subject']).'</td>
                            <td>'.htmlspecialchars($row['Message']).'</td>
                            <td>'.htmlspecialchars($row['Email']).'</td>
                            <td>'.htmlspecialchars($row['Phone_Number']).'</td>
                            <td>
                                <form action="" method="POST" class="actions">
                                    <input type="hidden" value="'.htmlspecialchars($row['Guest_ID']).'" name="guest_id" />
                                    <button type="submit" name="close" class="action-button cancelled '.($is_closed ? 'closed' : '').'" '.($is_closed ? 'onclick="return false";' : '').' onclick="return confirm(\'Confirm to close this inquiry\')">'.($is_closed ? 'closed' : 'close').'</button>
                                </form>

                            </td>
                        </tr>
                                ';
                            }
                        }
                    ?>                        
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="../../../includes/search-highlight.js"></script>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>