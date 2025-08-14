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
    <title>Create Account</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php include("../components/admin-menu.php")?>
    <section class="create-account-section">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="create-account-form">
            
            <div class="group">
                <label for="full-name">Trainer Name</label>
                <input type="text" name="full-name" id="full-name" placeholder="Full name">
            </div>

            <div class="inline-group">
                <div class="group">
                    <label for="phone" class="phone-label">Phone</label>
                    <input type="tel" name="phone" id="phone" placeholder="e.g +(55) 123 4567 890" required>
                </div>
                
                <div class="group">
                    <label for="speciality" class="speciality-label">Speciality</label>
                    <input type="text" name="speciality" id="speciality" placeholder="Speciality" required>
                </div>
            </div>
                
            <button type="submit" name="create" class="create-account-button">Create</button>

        </form>
    </section>

    <?php 
    if(isset($_POST['create'])){
        $trainer_fullname = trim($_POST['full-name']);
        $trainer_names = explode(" ", $trainer_fullname);
        $trainer_phone = trim($_POST['phone']);
        $trainer_speciality = trim($_POST['speciality']);

        $trainer_email = strtolower($trainer_names[0]) . "@fitzone.com";
        $role = "staff";
        $password = "Staff@fitzone.com";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql_users = "INSERT INTO users (First_Name, Last_Name, Phone, Email, Role, Password) VALUES (?, ?, ?, ?, ?,?)";

        $stmt = $conn->prepare($sql_users);
        
        if(!$stmt){
            die();
            echo '<script type="text/javascript">alert("Prepare Failed!");
            </script>';
        }

        $stmt->bind_param("ssisss", $trainer_names[0], $trainer_names[1], $trainer_phone, $trainer_email, $role, $hashed_password);

        if($stmt->execute()){
            $user_id = $conn->insert_id;
            
            $sql_trainers = "INSERT INTO trainers (User_ID, Name, Speciality) VALUES (?,?,?)";
            $stmt_trainer = $conn->prepare($sql_trainers);

            if(!$stmt_trainer){
                echo '<script type="text/javascript">alert("Prepare Failed To Add Trainer!");
                </script>';
                die();
                $stmt->close();
                $conn->close();
            }

            $stmt_trainer->bind_param("iss", $user_id, $trainer_fullname, $trainer_speciality);

            if($stmt_trainer->execute()){
                echo '<script type="text/javascript">alert("Account Created Successfully!");
                </script>';
            }
            else{
                echo '<script type="text/javascript">alert("Failed to create account!");
            </script>';
            }
        }
        else
        {
            echo '<script type="text/javascript">alert("Failed to create account!");
            </script>';
        }
        $stmt_trainer->close();
        $stmt->close();
    }
    $conn->close();
    ?>
</body>
</html>