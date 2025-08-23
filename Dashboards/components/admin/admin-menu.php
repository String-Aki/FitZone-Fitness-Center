<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <nav class="float-menu">
        <div class="displaying">
            <i class="fas fa-dumbbell menu-icon"></i>
            <span class="selected">
                <?php
                    if (isset($_GET['selected'])) 
                        {
                            echo htmlspecialchars($_GET['selected']);
                        }
                        else
                        {
                            echo "Admin";
                        }
                ?>
            </span>
        </div>
        <div class="extend">
           <ul class="menu-list">
            <li class="list"><a href="../Admin-Dashboard/create-account.php?selected=Create Account&uid=<?php echo htmlspecialchars($UID)?>" class="nav-link">Create Account</a></li>
            <li class="list"><a href="../Admin-Dashboard/manage-accounts.php?selected=Manage Accounts&uid=<?php echo htmlspecialchars($UID)?>" class="nav-link">Manage Accounts</a></li>
            <li class="list"><a href="../Admin-Dashboard/broadcast.php?selected=Broadcast&uid=<?php echo htmlspecialchars($UID)?>" class="nav-link">Broadcast</a></li>
            <li class="list"><a href="../Admin-Dashboard/Everything-Else/dashboard.php?uid=<?php echo htmlspecialchars($UID)?>" class="nav-link">Everything Else</a></li>
           </ul>
        </div>
    </nav>
    <script>
        const hoverElem = document.querySelector(".float-menu");
        const hoverElem2 = document.querySelector(".displaying")
        const showElem = document.querySelector(".extend");
        const iconToPower = document.querySelector(".menu-icon");
        
        const displayLink = document.querySelector(".selected");
        if(displayLink.textContent.trim() == "Admin")
            {
                hoverElem2.addEventListener("mouseenter", ()=>{
                    iconToPower.classList.remove("fa-dumbbell");
                    iconToPower.classList.add("fa-power-off");

                    document.querySelector(".fa-power-off").addEventListener("click",()=>{
                    window.location.href = "../../includes/logout.php?role=admin&uid=<?php echo htmlspecialchars($UID)?>";
                    })
                })
            }
        else
            {
            hoverElem2.addEventListener("mouseenter", ()=>{
            showElem.classList.add("active");
            iconToPower.classList.remove("fa-dumbbell");
            iconToPower.classList.add("fa-power-off");
            document.querySelector(".fa-power-off").addEventListener("click",()=>{
            window.location.href = "../../includes/logout.php?role=admin&uid=<?php echo htmlspecialchars($UID)?>";
        })
        });
            }
        hoverElem.addEventListener("mouseleave", ()=>{
            showElem.classList.remove("active")
            iconToPower.classList.remove("fa-power-off");
            iconToPower.classList.add("fa-dumbbell");
        });

    </script>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
</body>
</html>