<?php
    session_start();
    include("../../includes/dbconnect.php");
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
     <?php include("../components/admin/admin-menu.php")?>
    
    <section class="create-account-section">
        <form action="" method="post" class="create-account-form">
            <?php
                if(isset($_GET['update_id'])){
                    $Update_ID = $_GET['update_id']; 

                    $fetch_sql = "SELECT trainers.Trainer_ID, trainers.Name, trainers.Speciality, users.Phone FROM trainers JOIN users ON trainers.User_ID = users.User_ID WHERE users.User_ID ='$Update_ID'";

                    $fetch_result = $conn->query($fetch_sql);
                    $row = $fetch_result->fetch_assoc();
                }
                $fetch_result->free();
            ?>
            <div class="group">
                <label for="full-name">Trainer Name</label>
                <input type="text" name="full-name" id="full-name" placeholder="Full name" value="<?php echo $row['Name']?>">
            </div>

            <div class="inline-group">
                <div class="group">
                    <label for="phone" class="phone-label">Phone</label>
                    <input type="tel" name="phone" id="phone" placeholder="e.g +(55)1234567890" value="<?php echo $row['Phone']?>" required>
                </div>
                
                <div class="group">
                    <label for="speciality" class="speciality-label">Speciality</label>
                    <input type="text" name="speciality" id="speciality" placeholder="Speciality" value="<?php echo $row['Speciality']?>" required>
                </div>
            </div>
                
            <button type="submit" name="save" class="create-account-button">Save</button>

        </form>
    </section>

    <?php
        if(isset($_POST['save'])){
            $trainer_fullname = trim($_POST['full-name']);
            $trainer_names = explode(" ", $trainer_fullname);
            $trainer_phone = trim($_POST['phone']);
            $trainer_speciality = trim($_POST['speciality']);

            $update_query = "UPDATE users JOIN trainers ON users.User_ID = trainers.User_ID SET users.First_Name = '$trainer_names[0]', users.Last_Name = '$trainer_names[1]', users.Phone = '$trainer_phone', trainers.Name = '$trainer_fullname', trainers.Speciality = '$trainer_speciality' WHERE users.User_ID = $Update_ID";

            if($conn->query($update_query)){
                echo '<script type="text/javascript">alert("Changes Saved");
            window.location.href="./manage-accounts.php?selected=Edit Account";
            </script>';
            }
            else
                {
                echo '<script type="text/javascript">alert("Failed to Save Changes");
                </script>';
                }
        }
        $conn->close();
    ?>
</body>
</html>