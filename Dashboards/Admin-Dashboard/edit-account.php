<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php include("../components/admin-menu.php")?>
    
    <section class="create-account-section">
        <form action="" method="post" class="create-account-form">
            
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
                
            <button type="submit" class="create-account-button">Save</button>

        </form>
    </section>
</body>
</html>