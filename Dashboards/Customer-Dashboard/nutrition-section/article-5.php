<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title>Building a Plant-Based Nutrition Plan</title>
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
        <h1 class="article-h1">Building a Plant-Based Nutrition Plan</h1>
        <div class="section-img-container">
          <img
            src="../../../Assets/customer-dashboard-assets/nutrition-section-assets/5.png"
            alt="section-img"
            class="section-img"
          />
        </div>
        <p class="para">
          Going plant-based can supercharge your fitness goals, offering
          a sustainable way to nourish your body. At FitZone Fitness Center, we
          celebrate plant power as a path to strength and vitality. Let’s
          explore how to craft a nutrition plan that thrives on plants.
        </p>
        <br /><br />
        <p class="para">
          A plant-based diet focuses on foods like vegetables, fruits, grains,
          and legumes, minimizing or excluding animal products. It’s rich in
          fiber, antioxidants, and healthy fats, supporting fitness and health.
          Here’s how to build one for your FitZone journey.
        </p>
        <br />
        <h2 class="article-sub-headers">Energy Foundation: Carbs from Plants</h2>
        <p class="helper para">Plant-based carbs fuel your FitZone workouts.</p>
        <ol>
          <li>
            <strong>Whole Grains</strong>: Brown rice and oats provide lasting
            energy for cardio sessions.
          </li>
          <li>
            <strong>Natural Sugars</strong>: Bananas and dates offer quick
            energy boosts pre-workout.
          </li>
          <li>
            <strong>Fiber Boost</strong>: Lentils and chickpeas sustain energy
            and aid digestion.
          </li>
        </ol>

        <h2 class="article-sub-headers">Muscle Power: Plant Proteins</h2>
        <p class="helper para">Plants can build muscle at FitZone.</p>
        <ol>
          <li>
            <strong>Protein Sources</strong>: Tofu, tempeh, and black beans
            repair and grow muscles.
          </li>
          <li>
            <strong>Amino Acid Balance</strong>: Quinoa and hemp seeds provide
            complete proteins.
          </li>
          <li>
            <strong>Recovery Aid</strong>: Peas and edamame reduce muscle
            soreness post-exercise.
          </li>
        </ol>

        <h2 class="article-sub-headers">Health Protection: Antioxidants and Fats</h2>
        <p class="helper para">Plants protect your body during FitZone training.</p>
        <ol>
          <li>
            <strong>Antioxidant Shield</strong>: Berries and spinach fight
            inflammation from workouts.
          </li>
          <li>
            <strong>Healthy Fats</strong>: Avocado and flaxseeds support heart
            and joint health.
          </li>
          <li>
            <strong>Vitamin Boost</strong>: Kale and oranges enhance immunity
            and recovery.
          </li>
        </ol>

        <h2 class="article-sub-headers">Practical Ways to Go Plant-Based</h2>
        <p class="helper para">Start your plant journey with these FitZone tips:</p>
        <ol>
          <li>
            <strong>Veggie Stir-Fry</strong>: Cook broccoli, tofu, and brown
            rice with spices.
          </li>
          <li>
            <strong>Smoothie Power</strong>: Blend spinach, banana, and almond
            milk for breakfast.
          </li>
          <li>
            <strong>Lentil Soup</strong>: Make a hearty soup with carrots and
            spices for lunch.
          </li>
          <li>
            <strong>FitZone Workshop</strong>: Join our plant-based nutrition
            seminar.
          </li>
          <li>
            <strong>Snack Prep</strong>: Roast chickpeas with paprika for a
            crunchy treat.
          </li>
        </ol>

        <h2 class="article-sub-headers">A Note on Safety</h2>
        <p class="helper para">
          Ensure adequate B12 (e.g., fortified foods) and iron (pair with
          vitamin C) to avoid deficiencies. Consult a FitZone coach if
          transitioning to plant-based eating. A plant-based plan at FitZone fuels your fitness with nature’s best.
          Begin today, and let plants power your progress.
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
