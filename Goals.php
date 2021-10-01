<!-- Be sure to read through the Bootstrap Docs for components -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> Moneyplot | Goals</title>

  <!--CSS Ref -->
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

  <!-- Main area -->
  <main class="container">
    <div class="text-center py-5 px-3">
      <h1> Goals </h1>
      <p class="lead"> Set and view your goals
      </p>
    </div>
  </main>
  <!-- adds limit type and amount -->
  <div class="container">
    <div class="row">
      <div class="col">
        <p>Type of Limits</P>
      </div>
      <div class="col">
        <p>Limit Amount</P>
      </div>
      <div class="col">
      </div>
    </div>
    <form method="POST" action="goalsdata.php">
    <div class="row">
      <div class="col">
        <input name="date" type="date" class="form-control" placeholder="Date" aria-label="date">
      </div>
      <div class="col">
          <select name="limit" class="form-select">
            <option value="Spending"> Spending </option>
            <option value="Saving"> Saving </option>
          </select>
      </div>
      <div class="col">
        <input type="text" name="Amount" class="form-control" />
      </div>
      <div class="col">
        <button class="btn btn-success" type="submit" value="Submit">Add limit</button>
      </div>
    </div>
    </form>
    <br>

    <!--displays user's recent limits -->
    <p style="font-size: 30px; text-align: center;">Monthly Progress</P>
    <div id="chart-container">
      <canvas id="graphCanvas" height="60"></canvas>
    </div>
  </div>
  <br>

  <div class="container">
    <div class="row">
      <div class="col">
        <p style="font-size: 30px; text-align: center;">My Goals</p>
        <div id="chart-container">
      <canvas id="graphCanvas2" height="100"></canvas>
    </div>
      </div>
     
    </div>
  </div>

  <!-- table with recently inputted limits -->
  <main class="container">
    <div class="text-center py-5 px-3">
      <h3>Recent Limits</h3>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Type</th>
            <th scope="col">Amount</th>
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

          $sql_select = "SELECT s_limit, s_amount, s_date FROM spending";
          $result = $db_connection->query($sql_select);

          if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["s_date"] . "</td><td>" . $row["s_limit"] . "</td><td>" . $row["s_amount"] . "</td></tr>";
            }
          } else {
            echo "0 results";
          }

          $db_connection->close();
          ?>

        </tbody>
      </table>
    </div>

    

    <script>
    $(document).ready(function() {
      showGraph();
	  mygrade();
    });
function mygrade() {
      {
        $.post("SelectGoalsData.php",
          function(data) {
            console.log(data);

            var limit = [];
            var amount = [];

            var totalSpending = 0;
            var totalSaving = 0;
           

            for (var i in data) {

              limit.push(data[i].s_limit);
              amount.push(data[i].s_amount);

              if (data[i].s_limit == "Spending") {
                totalSpending += parseFloat(data[i].s_amount);
              } else if (data[i].s_limit == "Saving") {
                totalSaving += parseFloat(data[i].s_amount);
              } 
            }

            var graph = $("#graphCanvas2");

            var doughnutGraph = new Chart(graph, {
              type: 'doughnut',
              data: {
                labels: ['Spending', 'Saving'],
                datasets: [{
                  label: 'Amount per Category',
                  data: [totalSpending, totalSaving],
                  backgroundColor: [
                    'rgba(155, 199, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                  ],
                  borderColor: [
                    'rgba(155, 199, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              }
            });
          });
      }
    }
    function showGraph() {
      {
        $.post("SelectGoalsData.php",
          function(data) {
            //for testing purposes
            console.log(data);

            //initialization of variables
            var date = [];
            var amount = [];

            for (var i in data) {

              //push data from php file and put it into a javascript variable
              date.push(data[i].s_date); 
              amount.push(data[i].s_amount);

            }

            var graphTarget = $("#graphCanvas");

            var lineGraph = new Chart(graphTarget, {
              type: 'line',
              data: {
                labels: date,
                datasets: [{
                  label: 'Goal History',
                  data: amount,
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              }
            });
          });
      }
    }
  </script>

    <?php
      include 'footer.php';
    ?>

    <!-- JavasScript CDN for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>