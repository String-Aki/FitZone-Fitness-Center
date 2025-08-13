<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broadcasts</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php include("../components/admin-menu.php")?>

    <form action="" method="get" class="broadcast-form">
        <div class="group">
            <label for="broadcast">Share a broadcast</label>
            <textarea name="broadcast" id="broadcast" class="broadcast-field" rows="8"></textarea>
        </div>
        <button type="submit" class="broadcast-button"><i class="fas fa-microphone-lines broadcast-icon"></i> broadcast</button>
    </form>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>