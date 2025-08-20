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

    <?php include("../../components/admin/admin-dashboard-header.php");?>

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

                                $is_responded = !empty($row['Response']);
                                echo 
                                '
                                <tr>
                            <td>#'.htmlspecialchars($row['Guest_ID']).'</td>
                            <td class="full-name">'.htmlspecialchars($row['Name']).'</td>
                            <td>'.htmlspecialchars($row['Subject']).'</td>
                            <td>'.htmlspecialchars($row['Message']).'</td>
                            <td>'.htmlspecialchars($row['Email']).'</td>
                            <td>'.htmlspecialchars($row['Phone_Number']).'</td>
                            <td>
                                <form action="" method="POST" class="actions">
                                    <input type="hidden" value="'.htmlspecialchars($row['Guest_ID']).'" name="user_id" />
                                    <button type="submit" name="close" class="action-button cancelled" onclick="return confirm(\'Confirm to close this inquiry\')">Close</button>
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
<script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>