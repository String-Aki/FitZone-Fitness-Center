<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title>Nutrition Posts</title>
  </head>
  <body>

    <?php 
    
      session_start();
      include("../../../includes/dbconnect.php");

      $UID = $_GET['uid'] ?? null;
      $current_user = NULL;

      if($UID && isset($_SESSION['auth']['customer'][$UID])){
          $current_user = $_SESSION['auth']['customer'][$UID];
      }

      if($current_user === NULL){
          header('Location: ../../../Sign-In-Page/index.php');
          exit();
      }

      include("../../components/customer-dashboard-navbar.php");
      ?>

    <section class="nutrition-section dashboard-sections">
      <h1 class="nutrition-header">Nutrition</h1>
      <p class="about-page">
        Explore articles on fitness, nutrition, and wellness to support your
        journey.
      </p>

      <div class="featured">
        <div class="blog-img-container">
          <img src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/1.png" alt="blog-img" class="blog-img" />
        </div>
        <div class="contents">
          <p class="tag">Featured</p>
          <a class="title" href="./article-1.php?uid=<?php echo htmlspecialchars($UID); ?>">
            Mastering Macronutrients for Optimal Health
          </a>
          <p class="content-preview">
            Discover how to balance proteins, carbs, and fats to enhance your nutritional well-being.
          </p>
        </div>
      </div>

      <h2 class="latest section-subheader">Latest Articles</h2>

      <div class="articles">
        <div class="text-content">
          <a class="latest-title title" href="./article-2.php?uid=<?php echo htmlspecialchars($UID); ?>">
            Power-Packed Superfoods for Daily Energy
          </a>
          <p class="latest-contents content-preview">
            Explore the best superfoods to boost your energy and support a healthy lifestyle.
          </p>
        </div>
        <div class="article-img-container">
          <img src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/2.png" alt="article-img" class="article-img" />
        </div>
      </div>

      <div class="articles">
        <div class="text-content">
          <a class="latest-title title" href="./article-3.php?uid=<?php echo htmlspecialchars($UID); ?>">
            The Role of Vitamins in Fitness Nutrition
          </a>
          <p class="latest-contents content-preview">
            Learn how essential vitamins can improve your fitness performance and recovery.
          </p>
        </div>
        <div class="article-img-container">
          <img src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/3.png" alt="article-img" class="article-img" />
        </div>
      </div>

      <div class="articles">
        <div class="text-content">
          <a class="latest-title title" href="./article-4.php?uid=<?php echo htmlspecialchars($UID); ?>">
           Healthy Fats: Myths and Benefits Unveiled
          </a>
          <p class="latest-contents content-preview">
           Uncover the truth about healthy fats and their impact on your diet and health.
          </p>
        </div>
        <div class="article-img-container">
          <img src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/4.png" alt="article-img" class="article-img" />
        </div>
      </div>
      
      <div class="articles">
        <div class="text-content">
          <a class="latest-title title" href="./article-5.php?uid=<?php echo htmlspecialchars($UID); ?>">
            Building a Plant-Based Nutrition Plan
          </a>
          <p class="latest-contents content-preview">
            Get started with a plant-based diet to optimize your nutrition and fitness goals.
          </p>
        </div>
        <div class="article-img-container">
          <img src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/5.png" alt="article-img" class="article-img" />
        </div>
      </div>

    </section>
  </body>
</html>
