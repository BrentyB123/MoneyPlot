<!-- 
  Transactions.html

  This page allows the user to manually enter transaction data so the 
  system can then provide analytics for that information.

  Created by Brent Bemiller
 -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Moneyplot | Transactions</title>

  <!-- CSS links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <!-- Custom Stylesheet -->
  <link href="stylesheets/style.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

</head>

<body>

  <?php
  include 'navbar.php';
  ?>

  <!-- Main body content -->
  <main class="container">
    <div class="text-center py-5 px-3">

      <h1>Add Transactions</h1>

      <br />

      <form method="POST" action="TransactionsData.php">
        <!-- transaction input options -->
        <div class="row">
          <div class="col">
            <input name="date" type="date" class="form-control" placeholder="Date" aria-label="date">
          </div>
          <div class="col">
            <input name="description" type="text" class="form-control" placeholder="Description" aria-label="description">
          </div>
          <div class="col">
            <div class="input-group mb-2">
              <!-- <span class="input-group-text">$</span> -->
              <input name="amount" type="text" class="form-control" placeholder="Amount" aria-label="amount">
            </div>
          </div>
          <!-- Dropdown menu for selecting category -->
          <div class="col">
            <select name="category" class="form-select" aria-label="categories">
              <option selected>Category...</option>
              <option>Income</option>
              <option>Entertainment</option>
              <option>Bills</option>
              <option>Food</option>
              <option>Misc.</option>
            </select>
          </div>
          <!-- Dropdown menu for selecting spending/income -->
          <div class="col">
            <select name="type" class="form-select" aria-label="type">
              <option selected>Type...</option>
              <option>Spending</option>
              <option>Income</option>
            </select>
          </div>
        </div>

        <br />

        <div class="d-grid gap-2 col-4 mx-auto">
          <button class="btn btn-success" type="submit" value="Submit">Add Transaction</button>
        </div>

      </form>

      <br />

      <!-- table with recently inputted transactions -->
      <h3>Recent Transactions</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Category</th>
            <th scope="col">Type</th>
          </tr>
        </thead>
        <tbody>

          <?php

          //connection to db
          $db_connection = mysqli_connect("studentdb-maria.gl.umbc.edu", "rullah1", "rullah1", "rullah1");

          // Check connection
          if ($db_connection->connect_error) {
            die("Connection failed: " . $db_connection->connect_error);
          }

          $sql_select = "SELECT t_id, t_desc, t_amount, t_cat, t_date, t_type FROM trans";
          $result = $db_connection->query($sql_select);

          if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["t_date"] . "</td><td>" . $row["t_desc"] . "</td><td>$"
                . $row["t_amount"] . "</td><td>" . $row["t_cat"] . "</td><td>" . $row["t_type"] . "</td></tr>";
            }
          } else {
            echo "0 results";
          }

          $db_connection->close();
          ?>

        </tbody>
      </table>

      <br />

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="Analytics.php">
          <button class="btn btn-primary" type="button">View Analytics Dashboard</button>
        </a>
      </div>

    </div>
  </main>

  <?php
  include 'footer.php';
  ?>

  <!-- JavasScript CDN for Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>