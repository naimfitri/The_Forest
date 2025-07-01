<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
    <title>TheForest - Forest Management System</title>
    <style>
      :root {
        --color-primary: #2ecc71;
        --color-primary-dark: #27ae60;
        --color-secondary: #3498db;
        --color-white: #ffffff;
        --color-light: #f8f9fa;
        --color-dark: #2c3e50;
        --color-gray: #95a5a6;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body, header {
        margin: 0;
        padding: 0;
      }

      body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--color-light);
        color: var(--color-dark);
        line-height: 1.6;
      }

      .logo {
        color: var(--color-white);
        font-size: 28px;
        font-weight: 600;
        letter-spacing: 1px;
      }

      .logo span {
        color: var(--color-primary);
        font-weight: 700;
      }

      .menu-bar {
        background: linear-gradient(135deg, var(--color-dark) 0%, #1a2530 100%);
        height: 80px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;
        position: relative;
        box-shadow: var(--shadow);
        z-index: 1000;
      }

      .menu-bar ul {
        list-style: none;
        display: flex;
        align-items: center;
      }

      .menu-bar ul li {
        padding: 10px 16px;
        position: relative;
      }

      .menu-bar ul li a {
        font-size: 16px;
        color: var(--color-white);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
        display: flex;
        align-items: center;
        padding: 5px 0;
      }

      .menu-bar ul li a:hover {
        color: var(--color-primary);
      }

      .menu-bar ul li a i {
        margin-left: 8px;
        font-size: 14px;
      }

      .dropdown-menu {
        display: none;
        min-width: 200px;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
      }

      .menu-bar ul li:hover .dropdown-menu {
        display: block;
        position: absolute;
        left: 0;
        top: 100%;
        background-color: var(--color-white);
        animation: fadeIn 0.3s ease;
      }

      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
      }

      .dropdown-menu ul {
        display: block;
      }

      .dropdown-menu ul li {
        padding: 0;
        width: 100%;
      }

      .dropdown-menu ul li a {
        padding: 12px 18px;
        color: var(--color-dark);
        font-size: 15px;
        display: block;
      }

      .dropdown-menu ul li a:hover {
        background-color: var(--color-light);
        color: var(--color-primary-dark);
      }

      .hero {
        height: calc(100vh - 80px);
        background-image: url(./bg.jpg);
        background-position: center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      /* User auth styling */
      .auth-container {
        margin-left: auto;
        display: flex;
        align-items: center;
      }
      
      .auth-btn {
        background-color: var(--color-primary);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-left: 10px;
        display: inline-flex;
        align-items: center;
      }
      
      .auth-btn:hover {
        background-color: var(--color-primary-dark);
        transform: translateY(-2px);
      }
      
      .auth-btn i {
        margin-right: 5px;
      }
      
      .user-dropdown {
        position: relative;
      }
      
      .user-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: white;
        min-width: 180px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 5px;
        z-index: 1000;
      }
      
      .user-dropdown:hover .user-menu {
        display: block;
      }
      
      .user-menu a {
        display: block;
        padding: 10px 15px;
        color: var(--color-dark);
        text-decoration: none;
        transition: all 0.2s ease;
      }
      
      .user-menu a:hover {
        background-color: var(--color-light);
        color: var(--color-primary);
      }
      
      .user-menu .logout {
        border-top: 1px solid #eee;
      }
      
      .user-btn {
        background-color: transparent;
        border: 1px solid var(--color-primary);
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
      }
      
      .user-btn:hover {
        background-color: rgba(46, 204, 113, 0.2);
      }
      
      .user-btn i {
        margin-right: 6px;
      }
    </style>
  </head>
  <body>
    <div class="menu-bar">
      <h1 class="logo">The<span>Forest.</span></h1>
      <ul>
        <li><a href="/deforest/homepage.php">Home</a></li>
        <li><a href="/deforest/UI_Generate_Forest/Generate_Forest_UI.php">Generate Forest</a></li>
        
        <li>
          <a href="#">Production <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="/deforest/GraphBar/GraphBar.php">Tree</a></li>
              <li><a href="/deforest/GraphBar/GraphBarVolume.php">Volume</a></li>
            </ul>
          </div>
        </li>
        
        <li>
          <a href="#">Regime 45 <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="/deforest/Regime45/plot.php">Map Per Block</a></li>
              <li><a href="/deforest/Regime45/fullplot.php">Full Map</a></li>
              <li><a href="/deforest/Regime45/StandTable.php">Stand Table</a></li>
              <li><a href="/deforest/Regime45/victim.php">Victim</a></li>
              <li><a href="/deforest/Regime45/finaloutput.php">Final Output</a></li>
            </ul>
          </div>
        </li>
        
        <li>
          <a href="#">Regime 50 <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="/deforest/Regime50/plot.php">Map Per Block</a></li>
              <li><a href="/deforest/Regime50/fullplot.php">Full Map</a></li>
              <li><a href="/deforest/Regime50/StandTable.php">Stand Table</a></li>
              <li><a href="/deforest/Regime50/victim.php">Victim</a></li>
              <li><a href="/deforest/Regime50/finaloutput.php">Final Output</a></li>
            </ul>
          </div>
        </li>
        
        <li>
          <a href="#">Regime 55 <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="/deforest/Regime55/plot.php">Map Per Block</a></li>
              <li><a href="/deforest/Regime55/fullplot.php">Full Map</a></li>
              <li><a href="/deforest/Regime55/StandTable.php">Stand Table</a></li>
              <li><a href="/deforest/Regime55/victim.php">Victim</a></li>
              <li><a href="/deforest/Regime55/finaloutput.php">Final Output</a></li>
            </ul>
          </div>
        </li>
        
        <li>
          <a href="#">Regime 60 <i class="fas fa-caret-down"></i></a>
          <div class="dropdown-menu">
            <ul>
              <li><a href="/deforest/Regime60/plot.php">Map Per Block</a></li>
              <li><a href="/deforest/Regime60/fullplot.php">Full Map</a></li>
              <li><a href="/deforest/Regime60/StandTable.php">Stand Table</a></li>
              <li><a href="/deforest/Regime60/victim.php">Victim</a></li>
              <li><a href="/deforest/Regime60/finaloutput.php">Final Output</a></li>
            </ul>
          </div>
        </li>
      </ul>
      
      <div class="auth-container">
        <?php
        // Check if user is logged in
        if(isset($_SESSION['user_id'])) {
            echo '<div class="user-dropdown">
                <button class="user-btn">
                    <i class="fas fa-user-circle"></i>
                    ' . htmlspecialchars($_SESSION['username']) . '
                    <i class="fas fa-caret-down ml-2"></i>
                </button>
                <div class="user-menu">
                    <a href="/deforest/profile.php"><i class="fas fa-user-cog"></i> Profile</a>
                    <a href="/deforest/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>';
        } else {
            echo '<a href="/deforest/login.php" class="auth-btn"><i class="fas fa-sign-in-alt"></i> Login</a>
                  <a href="/deforest/register.php" class="auth-btn"><i class="fas fa-user-plus"></i> Register</a>';
        }
        ?>
      </div>
    </div>
  </body>
</html>
