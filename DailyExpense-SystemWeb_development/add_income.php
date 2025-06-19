<?php
include("session.php");

$incomeamount = "";
$income_date = date("Y-m-d");
$incomecategory = "Salary";

if (isset($_POST['add'])) {
    $incomeamount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];
    $incomecategory = $_POST['incomecategory'];

    // Modified query to include 'incomecategory'
    $income = "INSERT INTO income (user_id, income_amount, income_date, incomecategory) VALUES ('$userid', '$incomeamount', '$income_date', '$incomecategory')";
    $result = mysqli_query($con, $income) or die("Something Went Wrong!");

    header('location: add_income.php');
    exit(); // Recommended after header redirection
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Income Manager - Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/feather.min.js"></script>
    <style> .site-name {
    font-weight: bold;
    font-size: 1.5rem;
    color: #2d3e50;
    display: flex;
    align-items: center;
  }
  
  .site-name span[data-feather] {
    margin-right: 8px;
    color: #00aaff;
  }
  
  .highlight {
    color: #00aaff;
  }
  
  .site-name:hover {
    color: #007acc;
    transition: color 0.3s ease;
  }</style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
    <div class="user">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
    </div>
    <div class="sidebar-heading">Management</div>
    <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>

        <!-- Expense Dropdown -->
        <div class="dropdown">
            <a class="list-group-item list-group-item-action dropdown-toggle" href="#" id="expenseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span data-feather="dollar-sign"></span> Expense
            </a>
            <div class="dropdown-menu" aria-labelledby="expenseDropdown">
                <a href="add_expense.php" class="dropdown-item">Add Expense</a>
                <a href="manage_expense.php" class="dropdown-item">Manage Expense</a>
                <a href="view_expense.php" class="dropdown-item">View Expense</a>
            </div>
         
        </div>

        <!-- Income Dropdown -->
        <div class="dropdown">
            <a class="list-group-item list-group-item-action dropdown-toggle" href="#" id="incomeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span data-feather="briefcase"></span> Income
            </a>
            <div class="dropdown-menu" aria-labelledby="incomeDropdown">
                <a href="add_income.php" class="dropdown-item">Add Income</a>
                <a href="manage_income.php" class="dropdown-item">Manage Income</a>
            </div>
        </div>
        <a href="report.php" class="list-group-item list-group-item-action">
            <span data-feather="file-text"></span> Monthly Report
        </a>
    </div>
    
    <div class="sidebar-heading">Settings</div>
    <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
    </div>
</div>
<div id="page-content-wrapper">
<nav class="navbar navbar-expand-lg navbar-light border-bottom">
  <!-- Attractive Website Name with Icon -->
  <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
    <span data-feather="menu"></span>
  </button>
  <a class="navbar-brand site-name" href="#">
    <span data-feather="dollar-sign"></span> Finance <span class="highlight">Manager</span>
  </a>
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="profile.php">Your Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

    <div class="container">
        <h3 class="mt-4 text-center">Add Your Income</h3>
        <hr>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md" style="margin:0 auto;">
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="income_amount" class="col-sm-6 col-form-label"><b>Enter Amount($)</b></label>
                        <div class="col-md-6">
                            <input type="number" class="form-control col-sm-12" value="<?php echo $incomeamount; ?>" id="income_amount" name="income_amount" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="income_date" class="col-sm-6 col-form-label"><b>Date</b></label>
                        <div class="col-md-6">
                            <input type="date" class="form-control col-sm-12" value="<?php echo $income_date; ?>" name="income_date" id="income_date" required>
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-6 pt-0"><b>Category</b></legend>
                            <div class="col-md">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="incomecategory" value="Salary" <?php echo ($incomecategory == 'Salary') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="incomecategory1">Salary</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="incomecategory" value="Business" <?php echo ($incomecategory == 'Business') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="incomecategory2">Business</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="incomecategory" value="Investment" <?php echo ($incomecategory == 'Investment') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="incomecategory3">Investment</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="incomecategory" value="Freelance" <?php echo ($incomecategory == 'Freelance') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="incomecategory4">Freelance</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add Income</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/feather.min.js"></script>
<script>
    feather.replace()
</script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
