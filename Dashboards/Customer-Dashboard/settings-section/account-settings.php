<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <?php include("../../components/customer-dashboard-navbar.php"); ?>

    <section class="dashboard-sections">
        <h1 class="headers">Account Settings</h1>
        <div class="indicator-div">
            <h2 class="sub-header color">Manage your personal information and preferences</h2>
        </div>
        <hr class="line">

        <h3 class="section-subheader">Personal Information</h3>

        <form action="" method="post" enctype="multipart/form-data" class="all-forms">
            <?php
                $fetch_account_details = "SELECT First_Name, Last_Name, Phone, Email FROM users WHERE User_ID = '".$_SESSION['user_id']."'";

                $details = $conn->query($fetch_account_details);
                $fetch = $details->fetch_assoc();

                $fullname = $fetch['First_Name']." ".$fetch['Last_Name'];
            ?>
            <label for="Full-Name">Full Name</label>
            <input type="text" name="full-name" id="Full-Name" value="<?php echo htmlspecialchars($fullname)?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($fetch['Email'])?>">

            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($fetch['Phone'])?>">

            <label for="uploads">Upload Profile Picture</label>
            <input type="file" name="uploads" id="uploads" class="uploads">

            <button type="submit" class="settings-button" name="update">Update Information</button>
        </form>
    </section>

    <?php
        if(isset($_POST['update'])){
            $Full_Name = trim($_POST['full-name']);
            $Names = explode(" ", $Full_Name);
            $Phone = trim($_POST['phone']);
            $Email = trim($_POST['email']);
            $upload_path = NULL;
            if(isset($_FILES['uploads']) && $_FILES['uploads']['error'] != UPLOAD_ERR_NO_FILE){
            $target_dir = "../../../includes/Uploads/pfp/";
            $upload_name = basename($_FILES["uploads"]["name"]);
            $upload_path = $target_dir . $upload_name;

            if(!move_uploaded_file($_FILES['uploads']['tmp_name'], $upload_path)){
              echo '<script>alert("Failed to upload file")</script>';
              exit;
            }
            }

            if($upload_path !== NULL)
            {
            $update_query = "UPDATE users SET First_Name = ?, Last_Name = ?, Phone = ?, Email = ?, Profile_Img_Path = ? WHERE User_ID = '".$_SESSION['user_id']."'";

            $update_request = $conn->prepare($update_query);
            $update_request->bind_param("ssiss",$Names[0],$Names[1],$Phone, $Email, $upload_path);
            }
        
            else
            {
                $update_query = "UPDATE users SET First_Name = ?, Last_Name = ?, Phone = ?, Email = ? WHERE User_ID = '".$_SESSION['user_id']."'";
                $update_request = $conn->prepare($update_query);
                $update_request->bind_param("ssis",$Names[0],$Names[1],$Phone, $Email);
            }

            if($update_request->execute()){
                echo 
                '<script>
                alert("Update Successful");
                window.location.href = "../overview-section/dashboard-overview.php";
                </script>';
            }
            else 
            {
                echo 
                '<script>
                alert("Update Failed");
                window.location.href = "./account-settings.php";
                </script>';

            }
            $update_request->close();
        }
        $conn->close();
    ?>
</body>
</html>