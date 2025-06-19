<?php
include('session.php');
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

$warning_message = '';
$success_message = '';
$current_month = date('m');
$current_year = date('Y');
$selected_month = $current_month;
$selected_year = $current_year;

// Handle form submission for setting budget
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all necessary fields are set
    if (isset($_POST['budget_amount'], $_POST['month'], $_POST['year'])) {
        $budget_amount = $_POST['budget_amount'];
        $month = $_POST['month'];
        $year = $_POST['year'];

        if ($budget_amount <= 0) {
            $warning_message = "Budget amount must be greater than zero.";
        } else {
            // Insert or update the budget for the selected month and year
            $checkBudget = "SELECT * FROM budget WHERE user_id = ? AND month = ? AND year = ?";
            $stmt = $con->prepare($checkBudget);
            $stmt->bind_param("iii", $userid, $month, $year);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update the existing budget
                $updateBudget = "UPDATE budget SET budget_amount = ? WHERE user_id = ? AND month = ? AND year = ?";
                $updateStmt = $con->prepare($updateBudget);
                $updateStmt->bind_param("diii", $budget_amount, $userid, $month, $year);
                $updateStmt->execute();
                $success_message = "Budget updated successfully!";
            } 
            else {
                // Insert a new budget
                $insertBudget = "INSERT INTO budget (user_id, month, year, budget_amount) VALUES (?, ?, ?, ?)";
                $insertStmt = $con->prepare($insertBudget);
                $insertStmt->bind_param("iiid", $userid, $month, $year, $budget_amount);
                $insertStmt->execute();
                $success_message = "Budget set successfully!";
            }
        }
    } else {
        $warning_message = "Please fill in all fields to set the budget.";
    }
}

// Handle form submission for viewing budget and expenses for a specific month
if (isset($_POST['view_budget'])) {
    $selected_month = $_POST['month'];
    $selected_year = $_POST['year'];
}

// Fetch the budget for the selected month and year
$fetchBudget = "SELECT budget_amount FROM budget WHERE user_id = ? AND month = ? AND year = ?";
$stmt = $con->prepare($fetchBudget);
$stmt->bind_param("iii", $userid, $selected_month, $selected_year);
$stmt->execute();
$budgetResult = $stmt->get_result();
$currentBudget = ($budgetResult->num_rows > 0) ? $budgetResult->fetch_assoc()['budget_amount'] : 0;

// Calculate total expenses for the selected month and year
$totalExpensesQuery = "SELECT SUM(expense) as total_expenses FROM expenses WHERE user_id = ? AND MONTH(expensedate) = ? AND YEAR(expensedate) = ?";
$stmt = $con->prepare($totalExpensesQuery);
$stmt->bind_param("iii", $userid, $selected_month, $selected_year);
$stmt->execute();
$expensesResult = $stmt->get_result();
$total_expenses = ($expensesResult->num_rows > 0) ? $expensesResult->fetch_assoc()['total_expenses'] : 0;

// Check if expenses exceed the budget
if ($total_expenses > $currentBudget) {
    $warning_message = "Warning: Your expenses for this month have exceeded the budget!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Manage Budget</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .site-name {
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
    }
  </style>
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
            <a href="report.php" class="list-group-item list-group-item-action">
            <span data-feather="file-text"></span> Monthly Report
        </a>
        </div>
    </div>
    
    <div class="sidebar-heading">Settings</div>
    <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
    </div>
</div>

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light border-bottom">
        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>
        <a class="navbar-brand site-name" href="#">
          <span data-feather="dollar-sign"></span> Finance <span class="highlight">Manager</span>
        </a>
      </nav>

      <div class="container mt-5">
        <h2 class="text-center">Manage Monthly Budget</h2>

        <?php if ($success_message): ?>
          <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($warning_message): ?>
          <div class="alert alert-danger"><?php echo $warning_message; ?></div>
        <?php endif; ?>

        <!-- Set Budget Form -->
        <form method="POST" action="manage_budget.php" class="mt-4 p-4 border rounded">
          <div class="form-group">
            <label for="budget_amount">Budget Amount :</label>
            <input type="number" class="form-control" id="budget_amount" name="budget_amount" min="1" required>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="month">Select Month:</label>
              <select class="form-control" id="month" name="month" required>
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?php echo $m; ?>" <?php echo ($selected_month == $m) ? 'selected' : ''; ?>><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="year">Select Year:</label>
              <input type="number" class="form-control" id="year" name="year" min="2000" max="2099" value="<?php echo $selected_year ?>" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Set Budget</button>
        </form>

        <hr>

        <!-- View Budget and Expenses for the selected month -->
        <form method="POST" action="manage_budget.php" class="mt-4">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="view_month">Select Month:</label>
              <select class="form-control" id="view_month" name="month">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?php echo $m; ?>" <?php echo ($selected_month == $m) ? 'selected' : ''; ?>><?php echo date('F', mktime(0, 0, 0, $m, 1)); ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="view_year">Select Year:</label>
              <input type="number" class="form-control" id="view_year" name="year" min="2000" max="2099" value="<?php echo $selected_year ?>" required>
            </div>
          </div>
          <button type="submit" name="view_budget" class="btn btn-info">View Budget & Expenses</button>
        </form>

        <hr>

        <div class="mt-4 p-4 border rounded shadow-sm bg-white"> 
  <h4 class="font-weight-bold text-primary">
    Budget Summary for Selected Months in <?php echo $selected_year; ?>
  </h4>

  <table class="table table-bordered mt-3">
    <tbody>
      <tr>
        <th scope="row" class="text-primary">Total Budget for Selected Months</th>
        <td class="text-success">Rs. <?php echo number_format($currentBudget, 2); ?></td>
      </tr>
      <tr>
        <th scope="row" class="text-primary">Total Expenses for Selected Months</th>
        <td class="text-danger">Rs. <?php echo number_format($total_expenses, 2); ?></td>
      </tr>
    </tbody>
  </table>
</div>


      </div>
    </div>
  </div>

  <!-- Bootstrap core JS -->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script>
    feather.replace();
  </script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
