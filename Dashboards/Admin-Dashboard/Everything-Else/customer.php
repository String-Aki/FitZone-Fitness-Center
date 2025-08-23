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
    <link rel="stylesheet" href="./styles.css">
    <title>Customer Management</title>
</head>
<body>
        <?php include("../../components/admin/admin-dashboard-side-bar.php");?>

        <main>

        <?php include("../../components/admin/admin-dashboard-header.php");
        
        if(isset($_POST['del'])){

            $user_id = trim($_POST['user_id']);
            $delete_user = "DELETE FROM users WHERE User_ID = '".$user_id."'";

            $delete = $conn->query($delete_user);

            if($delete){
                echo
                '
                <script>alert(User Deleted Succefully);
                window.location.href="./customer.php?header_title=Customer Management&uid='.htmlspecialchars($UID).'"
                </script>
                ';
            }
            else 
            {
                echo
                '
                <script>alert(User Deletion Failed);
                window.location.href="./customer.php?header_title=Customer Management&uid='.htmlspecialchars($UID).'"
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
                            <th style="text-align: center;">Profile Picture</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Membership Type</th>
                            <th>Membership Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        $fetch_users = "SELECT u.*, m.Plan_Type,m.Membership_ID, m.Status FROM users u LEFT JOIN memberships m ON u.User_ID = m.User_ID LEFT JOIN memberships m2 ON u.User_ID = m2.User_ID AND m.Membership_ID < m2.Membership_ID WHERE u.Role = 'customer' AND m2.Membership_ID IS NULL";
                        $users = $conn->query($fetch_users);

                        if($users->num_rows > 0 ){
                            while($row = $users->fetch_assoc()){
                                
                                $correct_path = $row['Profile_Img_Path'];

                                $path = (!empty($row['Profile_Img_Path'])) ? $correct_path : "../../../Assets/customer-dashboard-assets/profile.png";

                                $membership_type = empty($row['Membership_ID']) ? "Guest" : $row['Plan_Type'];

                                echo
                                '
                                <tr>
                            <td>
                                <div class="profile-container pfp">
                                    <img src="'.htmlspecialchars($path).'" alt="Profile picture" class="avatar">
                                </div>
                            </td>
                            <td class="full-name">'.htmlspecialchars($row['First_Name']." ".$row['Last_Name']).'</td>
                            <td>'.htmlspecialchars($row['Email']).'</td>
                            <td style="text-align:center;">'.htmlspecialchars($row['Phone']).'</td>
                            <td style="text-align:center;">'.htmlspecialchars($membership_type).'</td>
                            <td style="text-align:center;">
                            '.htmlspecialchars($row['Status']).'
                            </td>
                            <td class="actions">
                                <form action="" method="POST" class="actions">
                                    <input type="hidden" value="'.htmlspecialchars($row['User_ID']).'" name="user_id" />
                                    <button type="submit" name="del" class="action-button cancelled" onclick="return confirm(\'Confirm to delete this account\')">Delete</button>
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
</body>
</body>
</html>