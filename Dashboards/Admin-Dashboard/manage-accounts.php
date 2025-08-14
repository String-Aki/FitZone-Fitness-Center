<?php
  session_start();
  include("../../includes/dbconnect.php");
  // error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <?php include("../components/admin-menu.php")?>
    <section class="manage-accounts-section">
      <form method="get" class="search-accounts">
        <div class="search-container">
          <input type="hidden" name="selected" value="Searching">
          <input
            type="text"
            name="searchFor"
            class="search-input"
            placeholder="Search Accounts"
          />
          <button type="submit" name="search" class="search-button" >
            <i class="fas fa-arrow-right search-icon"></i>
          </button>
        </div>
      </form>

      <?php

        if(isset($_GET['search'])){
          $search = trim($_GET['searchFor']);
          $search_query = "SELECT users.User_ID,users.Email, trainers.Name FROM users JOIN trainers ON users.User_ID = trainers.User_ID WHERE users.First_Name = '$search'";

          $search_results = $conn->query($search_query);
          if($search_results->num_rows > 0){
            while($searched_rows = $search_results->fetch_assoc()){
            echo 
            '
              <div class="account-container">
                <div class="info-wrap">
                  <div class="profile-img-container">
                      <img
                        src="../../Assets/customer-dashboard-assets/profile.png"
                        alt="profile-picture"
                        class="profile-picture"
                      />
                  </div>
                  <div class="text-wrap">
                      <p class="account-name">'.$searched_rows['Name'].'</p>
                      <p class="account-email">'.$searched_rows['Email'].'</p>
                  </div>
                </div>
                <div class="actions-wrap">
                    <i class="fas fa-pen-to-square edit-account" onclick="window.location.href=\'./edit-account.php?selected=Edit Account&update_id='.$searched_rows['User_ID'].'\'"></i>
                    <i class="fa-regular fa-circle-xmark delete-account"></i>
                </div>
              </div>
            ';
          }
          }

          else
          {
            echo
            '<div class="account-container">
                <h1 class="account-name not">Trainer Not Found</h1>
            </div>';
          }
        }

        else
        {
          $sql = "SELECT users.User_ID,users.Email, trainers.Name FROM users JOIN trainers ON users.User_ID = trainers.User_ID";

        $result = $conn->query($sql);

        if($result->num_rows > 0){
          
          while($row = $result->fetch_assoc()){
            echo 
            '
              <div class="account-container">
                <div class="info-wrap">
                  <div class="profile-img-container">
                      <img
                        src="../../Assets/customer-dashboard-assets/profile.png"
                        alt="profile-picture"
                        class="profile-picture"
                      />
                  </div>
                  <div class="text-wrap">
                      <p class="account-name">'.$row['Name'].'</p>
                      <p class="account-email">'.$row['Email'].'</p>
                  </div>
                </div>
                <div class="actions-wrap">
                    <i class="fas fa-pen-to-square edit-account" onclick="window.location.href=\'./edit-account.php?selected=Edit Account&update_id='.$row['User_ID'].'\'"></i>
                    <i class="fa-regular fa-circle-xmark delete-account" onclick="DeleteTrainer('.$row['User_ID'].')"></i>
                </div>
              </div>
            ';
          }
        }

        else
          {
            echo
            '<div class="account-container">
                <h1 class="account-name not">No Trainers Add Yet</h1>
            </div>';
          }
          $result->free();
          $conn->close();
        }
      ?>
    </section>

    <script>
      const searchCont = document.querySelector(".search-container");

      searchCont.addEventListener("click", () => {
        searchCont.style.outline = "auto";
      });
      document.addEventListener("click", (e) => {
        if (!searchCont.contains(e.target)) {
          searchCont.style.outline = "none";
        }
      });


      function DeleteTrainer(userid){
        if(confirm("Are you sure you want to delete this account?")){
          fetch('./delete-account.php',{
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'delete_id=' + userid
          })
          .then(response => response.json())
          .then(data => {
            console.log(data.success);
            if(data.success){
              alert('Account Deleted Successfully');
              window.location.reload();
            }
            else{
              alert('Account Deletion Failed!');
            }
          })
        }
      }
    </script>

    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
