<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Finance Tracker</title>

  <!-- Bootstrap core CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>

  <style>
    /* Full height for body and container */
    html, body {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Set primary background color and font color */
    .bg-primary-custom {
      background-color: #007bff !important;
      color: white;
    }

    .btn-custom {
      background-color: #28a745;
      color: white;
      font-size: 1.2rem;
      padding: 10px 20px;
      border-radius: 50px;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #218838;
    }

    /* Hero section with gradient background */
    .hero-section {
      background-image: linear-gradient(45deg, #0066cc, #00c6ff);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .hero-section h1 {
      font-size: 4rem;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .hero-section p {
      font-size: 1.25rem;
      margin-bottom: 30px;
    }

    /* Add hover effect to the navigation links */
    .nav-item .nav-link {
      color: white;
      transition: color 0.3s ease;
    }

    .nav-item .nav-link:hover {
      color: #ff6f61; /* Change to a warm accent color on hover */
    }

    /* Footer styling */
    footer {
      background-color: #343a40;
      color: white;
      padding: 20px 0;
    }

    footer a {
      color: #ff6f61;
    }

    footer a:hover {
      color: #ffd700;
    }
    /* Add hover effect to the navigation links */
.nav-item .nav-link {
  color: white;
  transition: color 0.3s ease;
}

.nav-item .nav-link:hover {
  color:green;
}

  </style>
</head>

<body>

  <header class="bg-primary-custom py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="logo d-flex align-items-center">
        <img src="finlogo.jpeg" alt="Finance Tracker" class="rounded-circle" width="50" height="50">
        <p class="h4 mb-0 ml-3">Finance Tracker</p>
      </div>
      <nav>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="Home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="About.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="Contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="register.php">Register</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero-section">
    <div>
      <h1 class="display-4 text-white">Manage Your Finances Effectively</h1>
      <p class="lead text-white">Track your expenses, income, and savings with ease using our personal finance management system.</p>
      <a href="register.php" class="btn btn-custom btn-lg">Get Started</a>
    </div>
  </section>

  <footer>
    <div class="container text-center">
      <p>&copy; 2024 Finance Tracker | <a href="Home.php">Home</a> | <a href="Contact.php">Contact Us</a></p>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="js/feather.min.js"></script>

  <script>
    feather.replace();
  </script>
</body>
</html>
