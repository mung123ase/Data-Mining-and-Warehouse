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

// Fetch total for a specific category if selected
$total_category_expense = null;
if (isset($_POST['expense_category'])) {
    $selected_category = $_POST['expense_category'];

    // If start and end date are provided, filter by the date range
    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $category_total_result = mysqli_query($con, "
            SELECT SUM(expense) AS total_expense 
            FROM expenses 
            WHERE user_id = '$userid' AND expensecategory = '$selected_category' 
            AND expensedate BETWEEN '$start_date' AND '$end_date'
        ");
    } else {
        // Otherwise, calculate the total for the category without date filtering
        $category_total_result = mysqli_query($con, "
            SELECT SUM(expense) AS total_expense 
            FROM expenses 
            WHERE user_id = '$userid' AND expensecategory = '$selected_category'
        ");
    }

    $total_category_expense = mysqli_fetch_assoc($category_total_result)['total_expense'];
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
            <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span> Profile</a>
            <a href="logout.php" class="list-group-item list-group-item-action"><span data-feather="power"></span> Logout</a>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light border-bottom">
            <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                <span data-feather="menu"></span>
            </button>
            <a class="navbar-brand site-name" href="#">
                <span data-feather="dollar-sign"></span> Finance <span class="highlight">Manager</span>
            </a>
        </nav>
        
        <div class="container-fluid">
            <h3 class="mt-4">Expense Report</h3>
            
            <!-- New Section: Total Expense by Specific Category within Date Range -->
            <h4 class="mt-4">Check Total Expense for a Category within Date Range</h4>
            <form method="post" class="form-inline mb-4">
                <label class="mr-2">Select Expense Category:</label>
                <select name="expense_category" class="form-control mr-2">
                    <option value="" disabled selected>Select Category</option>
                    <option value="Medicine">Medicine</option>
                    <option value="Food">Food</option>
                    <option value="Bills and Recharges">Bills and Recharges</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Clothings">Clothings</option>
                    <option value="Rent">Rent</option>
                    <option value="Household Items">Household Items</option>
                    <option value="Others">Others</option>
                </select>
                <label class="mr-2">Start Date:</label>
                <input type="date" name="start_date" class="form-control mr-2">
                <label class="mr-2">End Date:</label>
                <input type="date" name="end_date" class="form-control mr-2">
                <button type="submit" class="btn btn-primary">Show Total</button>
            </form>

            <?php if (!is_null($total_category_expense)): ?>
                <p>Total expense for <strong><?php echo $selected_category; ?></strong> between <strong><?php echo $start_date; ?></strong> and <strong><?php echo $end_date; ?></strong>: <?php echo $total_category_expense; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- JavaScript and Chart scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <script>
    feather.replace();
    // Chart scripts for expense_category_pie and date_range_expense_pie remain unchanged
  </script>
</body>
</html>