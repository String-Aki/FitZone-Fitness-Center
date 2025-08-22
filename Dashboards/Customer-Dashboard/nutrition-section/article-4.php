<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title>Healthy Fats: Myths and Benefits Unveiled</title>
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
        <h1 class="article-h1">Healthy Fats: Myths and Benefits Unveiled</h1>
        <div class="section-img-container">
          <img
            src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/4.png"
            alt="section-img"
            class="section-img"
          />
        </div>
        <p class="para">
          Fats often get a bad rap, but at FitZone Fitness Center, we know
          they’re essential for your health and performance. Dispelling myths
          about fats can unlock their benefits for energy, recovery, and more.
          Let’s dive into why healthy fats deserve a spot in your nutrition
          plan.
        </p>
        <br /><br />
        <p class="para">
          Healthy fats, found in foods like avocados and nuts, are crucial
          macronutrients that support bodily functions. Unlike trans fats, they
          promote heart health and hormone balance. Understanding their role can
          optimize your FitZone experience. Here’s the truth behind the myths.
        </p>
        <br />
        <h2 class="article-sub-headers">Heart Health: Fats That Protect</h2>
        <p class="helper para">Healthy fats support your cardiovascular system.</p>
        <ol>
          <li>
            <strong>Cholesterol Balance</strong>: Olive oil and almonds raise
            HDL (good cholesterol), countering heart disease risks.
          </li>
          <li>
            <strong>Anti-Inflammatory Power</strong>: Omega-3s from flaxseeds
            reduce inflammation, protecting arteries.
          </li>
          <li>
            <strong>Blood Pressure Aid</strong>: Avocados help lower blood
            pressure, enhancing workout circulation.
          </li>
        </ol>

        <h2 class="article-sub-headers">Hormone Balance: Fuel for Fitness</h2>
        <p class="helper para">Fats are key to hormonal health for FitZone members.</p>
        <ol>
          <li>
            <strong>Testosterone Boost</strong>: Nuts and fatty fish support
            muscle-building hormones.
          </li>
          <li>
            <strong>Estrogen Regulation</strong>: Seeds like chia balance
            estrogen levels for overall wellness.
          </li>
          <li>
            <strong>Energy Reserve</strong>: Fats provide a slow-burning fuel
            source for endurance.
          </li>
        </ol>

        <h2 class="article-sub-headers">Joint and Skin Benefits: Beyond the Myths</h2>
        <p class="helper para">Fats enhance physical and aesthetic outcomes.</p>
        <ol>
          <li>
            <strong>Joint Lubrication</strong>: Omega-3s from fish oil reduce
            joint stiffness during yoga sessions.
          </li>
          <li>
            <strong>Skin Health</strong>: Coconut oil and walnuts promote a
            glowing complexion post-workout.
          </li>
          <li>
            <strong>Weight Management</strong>: Healthy fats increase satiety,
            aiding FitZone weight goals.
          </li>
        </ol>

        <h2 class="article-sub-headers">Practical Ways to Embrace Healthy Fats</h2>
        <p class="helper para">Incorporate fats with these FitZone ideas:</p>
        <ol>
          <li>
            <strong>Avocado Toast</strong>: Spread on whole-grain bread for a
            pre-workout snack.
          </li>
          <li>
            <strong>Nut Butter Dip</strong>: Pair almond butter with apple
            slices for a quick energy boost.
          </li>
          <li>
            <strong>Salmon Dinner</strong>: Grill salmon with a side of veggies
            for a heart-healthy meal.
          </li>
          <li>
            <strong>FitZone Mix</strong>: Create a trail mix with walnuts,
            seeds, and dark chocolate.
          </li>
          <li>
            <strong>Dressing Twist</strong>: Use olive oil and lemon as a salad
            dressing.
          </li>
        </ol>

        <h2 class="article-sub-headers">A Note on Safety</h2>
        <p class="helper para">
          Avoid overindulging in high-calorie fats like coconut oil. Limit
          intake to recommended levels (e.g, 20-35% of daily calories) and
          avoid trans fats in processed foods. Seek advice from a FitZone nutrition expert for dietary
          concerns.
        </p>
        <p class="para">
          Healthy fats are your fitness allies, debunking myths and boosting
          health. Add them to your diet and feel the difference in your
          workouts.
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
