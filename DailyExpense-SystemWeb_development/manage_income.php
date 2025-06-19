<?php 
include("session.php");


if (isset($_GET['id']) && isset($_GET['action'])) {
    $income_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'delete') {
        // Delete the income record based on the income_id
        $delete_query = "DELETE FROM income WHERE income_id = '$income_id' AND user_id = '$userid'";
        mysqli_query($con, $delete_query) or die("Error deleting record!");
        header("Location: manage_income.php");
    } elseif ($action == 'edit') {
        // Fetch income details based on income_id for pre-filling the form
        $result = mysqli_query($con, "SELECT * FROM income WHERE income_id = '$income_id' AND user_id = '$userid'");
        $income_data = mysqli_fetch_assoc($result);
    }
}

// Process the form submission for editing
if (isset($_POST['edit'])) {
    $income_id = $_POST['income_id'];  // Include income_id in the form for reference
    $income_amount = $_POST['income_amount'];
    $income_date = $_POST['income_date'];
    $incomecategory = $_POST['incomecategory'];

    // Update the income record
    $update_query = "UPDATE income SET income_amount = '$income_amount', income_date = '$income_date', incomecategory = '$incomecategory' WHERE income_id = '$income_id' AND user_id = '$userid'";
    mysqli_query($con, $update_query) or die("Error updating record!");
    header("Location: manage_income.php");
}

$incomeRecords = mysqli_query($con, "SELECT * FROM income WHERE user_id='$userid'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Income</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
    <link href="css/style.css" rel="stylesheet">
    <script src="js/feather.min.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
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
            <h3 class="mt-4 text-center">Manage Your Income</h3>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Income Category</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; while ($row = mysqli_fetch_array($incomeRecords)) { ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['income_date']; ?></td>
                                    <td>Rs.<?php echo  $row['income_amount']; ?></td>
                                    <td><?php echo $row['incomecategory']; ?></td>
                                    <td class="text-center">
                                        <a href="add_income.php?id=<?php echo $row['income_id']; ?>&action=edit" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="manage_income.php?id=<?php echo $row['income_id']; ?>&action=delete" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
                                    </td>
                                </tr>
                            <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'edit'): ?>
    <div class="container mt-4">
        <h3>Edit Income</h3>
        <form action="" method="POST">
            <input type="hidden" name="income_id" value="<?php echo $income_id; ?>">
            <div class="form-group">
                <label>Amount</label>
                <input type="number" class="form-control" name="income_amount" value="<?php echo $income_data['income_amount']; ?>" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" name="income_date" value="<?php echo $income_data['income_date']; ?>" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="incomecategory" class="form-control">
                    <option value="Salary" <?php echo ($income_data['incomecategory'] == 'Salary') ? 'selected' : ''; ?>>Salary</option>
                    <option value="Business" <?php echo ($income_data['incomecategory'] == 'Business') ? 'selected' : ''; ?>>Business</option>
                    <option value="Investment" <?php echo ($income_data['incomecategory'] == 'Investment') ? 'selected' : ''; ?>>Investment</option>
                    <option value="Freelance" <?php echo ($income_data['incomecategory'] == 'Freelance') ? 'selected' : ''; ?>>Freelance</option>
                </select>
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Update Income</button>
        </form>
    </div>
<?php endif; ?>

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
