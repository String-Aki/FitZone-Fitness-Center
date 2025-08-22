<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title>The Role of Vitamins in Fitness Nutrition</title>
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
    
    <section class="dashboard-sections">
      <i onclick="window.location.href='./nutrition.php?uid=<?php echo htmlspecialchars($UID); ?>'" class="fas fa-arrow-left back"></i>
      <article class="all-articles">
        <h1 class="article-h1">The Role of Vitamins in Fitness Nutrition</h1>
        <div class="section-img-container">
          <img
            src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/3.png"
            alt="section-img"
            class="section-img"
          />
        </div>
        <p class="para">
          Vitamins are the unsung heroes of your FitZone fitness journey,
          quietly supporting every rep and stretch. From boosting energy to
          aiding recovery, these micronutrients play a critical role in keeping
          you at your best. At FitZone Fitness Center, we emphasize nutrition as
          the foundation of performance. Let’s uncover how vitamins enhance your
          workout results.
        </p>
        <br /><br />
        <p class="para">
          Vitamins are organic compounds essential for growth, energy, and
          repair, though needed in small amounts. They work alongside
          macronutrients to optimize fitness outcomes. A diet rich in colorful
          fruits and veggies can meet your needs. Here’s why vitamins are key
          for FitZone members.
        </p>
        <br />
        <h2 class="article-sub-headers">Energy Production: Powering Your Workouts</h2>
        <p class="helper para">Vitamins turn food into fuel for FitZone sessions.</p>
        <ol>
          <li>
            <strong>B Vitamins (B1, B6, B12)</strong>: Found in whole grains and
            eggs, they help convert carbs into energy, reducing fatigue.
          </li>
          <li>
            <strong>Vitamin C</strong>: Citrus fruits boost iron absorption,
            sustaining energy during cardio.
          </li>
          <li>
            <strong>Mitochondrial Support</strong>: Biotin and pantothenic acid
            enhance cellular energy production.
          </li>
        </ol>

        <h2 class="article-sub-headers">Recovery Support: Healing Muscles</h2>
        <p class="helper para">Vitamins accelerate recovery after FitZone workouts.</p>
        <ol>
          <li>
            <strong>Vitamin E</strong>: Nuts and seeds protect muscle cells from
            oxidative damage post-exercise.
          </li>
          <li>
            <strong>Vitamin D</strong>: Fatty fish and fortified foods aid
            muscle repair and reduce inflammation.
          </li>
          <li>
            <strong>Vitamin K</strong>: Leafy greens support blood clotting,
            minimizing bruising from intense training.
          </li>
        </ol>

        <h2 class="article-sub-headers">Immune Defense: Staying in the Game</h2>
        <p class="helper para">A robust immune system keeps you training at FitZone.</p>
        <ol>
          <li>
            <strong>Vitamin A</strong>: Carrots and sweet potatoes maintain skin
            and mucous membranes as barriers.
          </li>
          <li>
            <strong>Vitamin C</strong>: Peppers and strawberries fight off
            colds, keeping you consistent.
          </li>
          <li>
            <strong>Folate</strong>: Legumes support cell renewal, aiding
            recovery and immunity.
          </li>
        </ol>

        <h2 class="article-sub-headers">Practical Ways to Boost Vitamins</h2>
        <p class="helper para">Incorporate vitamins easily with these FitZone tips:</p>
        <ol>
          <li>
            <strong>Colorful Salad</strong>: Mix spinach, bell peppers, and
            oranges for a vitamin-packed side.
          </li>
          <li>
            <strong>Smoothie Boost</strong>: Add kale and a splash of orange
            juice to your post-workout shake.
          </li>
          <li>
            <strong>Snack Smart</strong>: Grab a handful of almonds and a kiwi
            for a quick vitamin hit.
          </li>
          <li>
            <strong>FitZone Plan</strong>: Work with our coaches to track
            vitamin intake weekly.
          </li>
          <li>
            <strong>Fortified Option</strong>: Enjoy a bowl of fortified cereal
            with milk for breakfast.
          </li>
        </ol>

        <h2 class="article-sub-headers">A Note on Safety</h2>
        <p class="helper para">
          Vitamins are beneficial but can be harmful in excess. Avoid high-dose
          supplements without guidance, as they may cause toxicity (e.g., too
          much Vitamin A). Consult a FitZone nutrition expert for personalized
          advice.
        </p>
        <p class="para">
          Vitamins are your fitness allies at FitZone, enhancing energy,
          recovery, and immunity. Start adding them to your diet today, and
          watch your performance soar.
        </p>

        <h2 class="written-by">Written by FitZone Fitness Team</h2>
        <p class="written-by-para para">Your partners in health and fitness at FitZone Fitness Center</p>
      </article>
    </section>
    <script
      src="https://kit.fontawesome.com/15767cca17.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
