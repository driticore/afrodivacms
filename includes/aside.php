<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="apple-touch-icon" sizes="180x180" href="Images/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="Images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="Images/favicon-16x16.png">
  <link rel="manifest" href="Images/site.webmanifest">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Afro Diva CMS</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body {
      background-color: gray;
    }

    /* Default Sidebar Styles */
    .sidebar {
      width: 20%;
      height: 100vh;
      top: 0;
      position: fixed;
      background-color: black;
      overflow: auto;
      transition: width 0.3s;
    }

    .sidebar img {
      display: block;
      margin: 0 auto;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      display: flex;
      align-items: center;
      padding: 15px;
      border-radius: 10px;
      margin: 10px;
    }

    .sidebar a.active {
      background-color: gray;
    }

    .sidebar a:hover {
      background-color: gray;
    }

    /* Navbar Toggle Button */
    .navbar-toggle {
      display: none;
      font-size: 24px;
      color: white;
      background-color: black;
      border: none;
      cursor: pointer;
      padding: 15px;
      position: fixed;
      top: 0;
      right: 0;
      z-index: 1000;
    }

    .navbar-toggle:hover {
      background-color: gray;
    }

    /* Media Query for Mobile Devices */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -100%;
        transition: left 0.3s;
      }

      .sidebar.active {
        left: 0;
      }

      .navbar-toggle {
        display: block;
      }

      .sidebar a {
        text-align: center;
        padding: 15px;
        display: block;
        margin: 0;
      }
    }

    /* Content area adjustments for mobile */
    @media (max-width: 768px) {
      body {
        margin-top: 50px;
        /* Adjust for navbar height */
      }
    }
  </style>
</head>

<body>

  <button class="navbar-toggle" id="navbarToggle">
    <i class="fas fa-bars"></i> <!-- Font Awesome Menu Icon -->
  </button>

  <div class="sidebar" id="sidebar">
    <img src="Images/logo.png" width="100px" height="100px" alt="Afro Diva Logo">

    <a href="dashboard.php" class="<?php if ($current_page == 'dashboard.php')
      echo 'active'; ?>">
      <i class="fas fa-tachometer-alt"></i> <!-- Font Awesome Dashboard Icon -->
      <span style="margin-left: 10px;">Dashboard</span>
    </a>
    <a href="products.php" class="<?php if ($current_page == 'products.php')
      echo 'active'; ?>">
      <i class="fas fa-boxes"></i> <!-- Font Awesome Products Icon -->
      <span style="margin-left: 10px;">Product Management</span>
    </a>
    <a href="users.php" class="<?php if ($current_page == 'users.php')
      echo 'active'; ?>">
      <i class="fas fa-users"></i> <!-- Font Awesome Users Icon -->
      <span style="margin-left: 10px;">User Management</span>
    </a>
    <a href="logout.php">
      <i class="fas fa-sign-out-alt"></i> <!-- Font Awesome Logout Icon -->
      <span style="margin-left: 10px;">Logout</span>
    </a>
  </div>

  <?php
  include("includes/toast.php");
  get_message();
  ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>


  <script>
    const sidebar = document.getElementById('sidebar');
    const navbarToggle = document.getElementById('navbarToggle');

    navbarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });

    const toastElement = document.querySelector('.toast');
    if (toastElement) {
      const toast = new bootstrap.Toast(toastElement);
      toast.show();
    }
  </script>



</body>

</html>