<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

// Default selected month and year for initial expense category and line charts
$selected_month = isset($_POST['month']) ? $_POST['month'] : date('m');
$selected_year = isset($_POST['year']) ? $_POST['year'] : date('Y');

// Fetch expense categories and their total amount for the selected month and year
$exp_category_dc = mysqli_query($con, "
    SELECT expensecategory, SUM(expense) AS total_expense 
    FROM expenses 
    WHERE user_id = '$userid' AND MONTH(expensedate) = '$selected_month' AND YEAR(expensedate) = '$selected_year'
    GROUP BY expensecategory
");

// Fetch daily expenses and income for the line chart
$exp_amt_line = mysqli_query($con, "
    SELECT expensedate, SUM(expense) AS daily_expense 
    FROM expenses 
    WHERE user_id = '$userid' AND MONTH(expensedate) = '$selected_month' AND YEAR(expensedate) = '$selected_year'
    GROUP BY expensedate
");

$inc_amt_line = mysqli_query($con, "
    SELECT income_date, SUM(income_amount) AS daily_income 
    FROM income
    WHERE user_id = '$userid' AND MONTH(income_date) = '$selected_month' AND YEAR(income_date) = '$selected_year'
    GROUP BY income_date
");

// Fetch data for date range filter if provided
$filtered_expenses = [];
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $filtered_expenses_result = mysqli_query($con, "
        SELECT expensecategory, SUM(expense) AS total_expense 
        FROM expenses 
        WHERE user_id = '$userid' AND expensedate BETWEEN '$start_date' AND '$end_date'
        GROUP BY expensecategory
    ");
    while ($row = mysqli_fetch_assoc($filtered_expenses_result)) {
        $filtered_expenses[] = $row;
    }
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
  

  <div class="container-fluid">
    <!-- Filter Form for Monthly and Date Range -->
    <h3 class="mt-4">Expense Report</h3>
    <form method="post" class="form-inline mb-4">
      <label class="mr-2">Select Month:</label>
      <select name="month" class="form-control mr-2">
        <?php for ($m = 1; $m <= 12; $m++): ?>
          <option value="<?php echo $m; ?>" <?php if ($m == $selected_month) echo 'selected'; ?>>
            <?php echo date('F', mktime(0, 0, 0, $m, 10)); ?>
          </option>
        <?php endfor; ?>
      </select>
      <label class="mr-2">Select Year:</label>
      <select name="year" class="form-control mr-2">
        <?php for ($y = date('Y'); $y >= 2000; $y--): ?>
          <option value="<?php echo $y; ?>" <?php if ($y == $selected_year) echo 'selected'; ?>>
            <?php echo $y; ?>
          </option>
        <?php endfor; ?>
      </select>
      <button type="submit" class="btn btn-primary">Filter by Month</button>
    </form>

    <!-- Date Range Filter Form -->
    <form method="post" class="form-inline mb-4">
      <label class="mr-2">Start Date:</label>
      <input type="date" name="start_date" class="form-control mr-2" required>
      <label class="mr-2">End Date:</label>
      <input type="date" name="end_date" class="form-control mr-2" required>
      <button type="submit" class="btn btn-primary">Filter by Date Range</button>
    </form>

    <!-- Display Selected Date Range if Filter Applied -->
    <?php if (isset($start_date) && isset($end_date)): ?>
      <p>Showing expenses from <strong><?php echo $start_date; ?></strong> to <strong><?php echo $end_date; ?></strong>.</p>
    <?php endif; ?>

    <div class="row">
      <!-- Expense by Category for Selected Month -->
      <div class="col-md">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title text-center">Expense by Category (Selected Month)</h5>
          </div>
          <div class="card-body">
            <canvas id="expense_category_pie" height="50"></canvas>
          </div>
        </div>
      </div>

      <!-- Expense by Category for Date Range -->
      <?php if (!empty($filtered_expenses)): ?>
      <div class="col-md">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title text-center">Expense by Category (Date Range)</h5>
          </div>
          <div class="card-body">
            <canvas id="date_range_expense_pie" height="50"></canvas>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <script>
    feather.replace();

    // Expense by Category - Pie Chart for Selected Month
    var ctxCategory = document.getElementById('expense_category_pie').getContext('2d');
    var expenseCategoryChart = new Chart(ctxCategory, {
      type: 'pie',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) { echo '"' . $a['expensecategory'] . '",'; } ?>],
        datasets: [{
          data: [<?php mysqli_data_seek($exp_category_dc, 0); while ($b = mysqli_fetch_array($exp_category_dc)) { echo $b['total_expense'] . ','; } ?>],
          backgroundColor: ['#6f42c1', '#dc3545', '#28a745', '#007bff', '#ffc107', '#20c997', '#17a2b8', '#fd7e14', '#e83e8c', '#6610f2']
        }]
      }
    });

    // Expense by Category - Pie Chart for Date Range Filter
    <?php if (!empty($filtered_expenses)): ?>
    var ctxDateRange = document.getElementById('date_range_expense_pie').getContext('2d');
    var dateRangeExpenseChart = new Chart(ctxDateRange, {
      type: 'pie',
      data: {
        labels: [<?php foreach ($filtered_expenses as $expense) { echo '"' . $expense['expensecategory'] . '",'; } ?>],
        datasets: [{
          data: [<?php foreach ($filtered_expenses as $expense) { echo $expense['total_expense'] . ','; } ?>],
          backgroundColor: ['#6f42c1', '#dc3545', '#28a745', '#007bff', '#ffc107', '#20c997', '#17a2b8', '#fd7e14', '#e83e8c', '#6610f2']
        }]
      }
    });
    <?php endif; ?>
  </script>
</body>
</html>