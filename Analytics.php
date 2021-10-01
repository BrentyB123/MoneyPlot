<!-- 
  Analytics.html

  Advanced analytics based on the transactions that the user inputs.

  Created by Russel Reyes
 -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Moneyplot | Advanced Analytics</title>

  <!-- CSS links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <!-- Custom Stylesheet -->
  <link href="stylesheets/style.css" rel="stylesheet" />
  <link href="stylesheets/style - russel.css" rel="stylesheet" />
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
      <h1>Advanced Analytics</h1>
      <p class="lead">
        Your spending dashboard
      </p>

      <div class="container">
        <div class="row">
		  <div class="col-3">
            <div class="card" style="height: 18rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>Recent Transaction</b><br /><br /></p>
				  <?php
					//connection to db
					$db_connection = mysqli_connect("studentdb-maria.gl.umbc.edu", "rullah1", "rullah1", "rullah1");

					// Check connection
					if ($db_connection->connect_error) {
					die("Connection failed: " . $db_connection->connect_error);
					}

					$sql_select = "SELECT t_amount, t_cat, t_desc, t_date FROM trans WHERE t_id = (SELECT max(t_id) FROM trans);";
					$result = $db_connection->query($sql_select);

					if (mysqli_num_rows($result) > 0) {
					  while($row_data = mysqli_fetch_assoc($result)){
						echo "<p style=\"text-align:left;\"><b>Date:</b> ".$row_data["t_date"]."<br />".
						 "<b>Amount:</b> $".$row_data["t_amount"]."<br />".
						 "<b>Category:</b> ".$row_data["t_cat"]."<br />".
						 "<b>Description:</b> ".$row_data["t_desc"]."</p>";
					  }
					}
					else {
						echo "No recent transactions!";
					}

					$result->close();

					$db_connection->close();
				  ?>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card" style="height: 18rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>% Spending on Category</b></p>
                <div id="chart-container">
                  <canvas id="graphCSpending"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card" style="height: 18rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>% Spending and Income</b></p>
                <div id="chart-container">
                  <canvas id="graphCSaving"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p class="clear"></p>
		
		<div class="row">
          <div class="col">
            <div class="card" style="height: 23rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>Spending Line Graph</b></p>
                <div id="chart-container">
                  <canvas id="graphSpending"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card" style="height: 23rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>Savings Line Graph</b></p>
                <div id="chart-container">
                  <canvas id="graphSaving"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <p class="clear"></p>
		
        <div class="row">
          <div class="col">
            <div class="card" style="height: 22rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>Past Spending</b></p>
                <div id="chart-container">
                  <canvas id="graphPSpending"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card" style="height: 22rem; border-radius: 25px;">
              <div class="card-body">
                <p><b>Spending & Income</b></p>
                <div id="chart-container">
                  <canvas id="graphPSaving"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Start of chart js -->

  <script>
    $(document).ready(function() {
      showCSpendingGraph();
	  showCSavingGraph();
	  showPSpendingGraph();
	  showPSavingGraph();
	  showSpendingGraph();
	  showSavingGraph();
    });

    function showCSpendingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
            var category = [];
			
            var amount = 0;
            var totalEntertainmentAmount = 0;
            var totalFoodAmount = 0;
            var totalBillsAmount = 0;
            var totalMiscAmount = 0;

            for (var i in data) {

              category.push(data[i].t_cat);
              amount += parseFloat(data[i].t_amount);

              if (data[i].t_cat == "Entertainment") {
                totalEntertainmentAmount += parseFloat(data[i].t_amount);
              } else if (data[i].t_cat == "Food") {
                totalFoodAmount += parseFloat(data[i].t_amount);
              } else if (data[i].t_cat == "Bills") {
                totalBillsAmount += parseFloat(data[i].t_amount);
              } else if (data[i].t_cat == "Misc.") {
                totalMiscAmount += parseFloat(data[i].t_amount);
              }
            }
			

            var graphTarget1 = $("#graphCSpending");

            var doughnutGraph1 = new Chart(graphTarget1, {
              type: 'doughnut',
              data: {
                labels: ['Bills', 'Entertainment', 'Food', 'Misc.'],
                datasets: [{
                  label: 'Amount per Category',
                  data: [totalBillsAmount, totalEntertainmentAmount, totalFoodAmount, totalMiscAmount],
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
              },
			  options: {
				tooltips: {
				  callbacks: {
					label: function(tooltipItem, data) {
					  return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2)
					       + ' (' + ((data['datasets'][0]['data'][tooltipItem['index']] / amount) * 100).toFixed(2) + '%)';
					}
				  }
				}
			  }
            });
          });
      }
    }
	
    function showCSavingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
			var transactType = [];
			
			var amount = 0;
			var totalSpendingAmount = 0;
			var totalIncomeAmount = 0;

            for (var i in data) {

              transactType.push(data[i].t_type);
              amount += parseFloat(data[i].t_amount);

			  if (data[i].t_type == "Spending") {
                totalSpendingAmount += parseFloat(data[i].t_amount);
              } else if (data[i].t_type == "Income") {
                totalIncomeAmount += parseFloat(data[i].t_amount);
              } 
            }
			
            var graphTarget2 = $("#graphCSaving");

			var doughnutGraph2 = new Chart(graphTarget2, {
              type: 'doughnut',
              data: {
                labels: ['Spending', 'Income'],
                datasets: [{
                  label: 'Amount per Category',
                  data: [totalSpendingAmount, totalIncomeAmount],
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              },
			  options: {
				tooltips: {
				  callbacks: {
					label: function(tooltipItem, data) {
					  return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']].toFixed(2)
					       + ' (' + ((data['datasets'][0]['data'][tooltipItem['index']] / amount) * 100).toFixed(2) + '%)';
					}
				  }
				}
			  }
            });
          });
      }
    }
	
	function showPSpendingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
			var date = [];
			var entertainmentAmount = [];
			var foodAmount = [];
			var billsAmount = [];
			var miscAmount = [];

            for (var i in data) {

			  date.push(data[i].t_date);
			  
			  if (data[i].t_cat == "Entertainment") {
                entertainmentAmount.push(data[i].t_amount);
				foodAmount.push(null);
				billsAmount.push(null);
				miscAmount.push(null);
              } else if (data[i].t_cat == "Food") {
				entertainmentAmount.push(null);
                foodAmount.push(data[i].t_amount);
				billsAmount.push(null);
				miscAmount.push(null);
              } else if (data[i].t_cat == "Bills") {
				entertainmentAmount.push(null);
				foodAmount.push(null);
                billsAmount.push(data[i].t_amount);
				miscAmount.push(null);
              } else if (data[i].t_cat == "Misc.") {
				entertainmentAmount.push(null);
				foodAmount.push(null);
				billsAmount.push(null);
                miscAmount.push(data[i].t_amount);
              }
			  
            }
			
            var graphTarget3 = $("#graphPSpending");

			var lineGraph1 = new Chart(graphTarget3, {
              type: 'line',
              data: {
                labels: date,
                datasets: [{
                  label: 'Entertainment',
                  data: entertainmentAmount,
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }, {
				  label: 'Food',
                  data: foodAmount,
                  backgroundColor: [
					'rgba(54, 162, 235, 0.2)'
                  ],
                  borderColor: [
                    'rgba(54, 162, 235, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }, {
				  label: 'Bills',
                  data: billsAmount,
                  backgroundColor: [
                    'rgba(255, 206, 86, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 206, 86, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }, {
				  label: 'Misc.',
                  data: miscAmount,
                  backgroundColor: [
                    'rgba(75, 192, 192, 0.2)'
                  ],
                  borderColor: [
                    'rgba(75, 192, 192, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              },
			  options: {
				spanGaps: true
			  }
			});
          });
      }
    }
	
	function showPSavingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
			var date = [];
			var spendingAmount = [];
			var incomeAmount = [];

            for (var i in data) {

			  date.push(data[i].t_date);
			  
			  if (data[i].t_type == "Spending") {
                spendingAmount.push(data[i].t_amount);
				incomeAmount.push(null);
              } else if (data[i].t_type == "Income") {
                incomeAmount.push(data[i].t_amount);
				spendingAmount.push(null);
              } 
			  
            }
			
            var graphTarget4 = $("#graphPSaving");

			var lineGraph2 = new Chart(graphTarget4, {
              type: 'line',
              data: {
                labels: date,
                datasets: [{
                  label: 'Spending',
                  data: spendingAmount,
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }, {
				  label: 'Income',
                  data: incomeAmount,
                  backgroundColor: [
					'rgba(54, 162, 235, 0.2)'
                  ],
                  borderColor: [
                    'rgba(54, 162, 235, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              },
			  options: {
				spanGaps: true
			  }
			});
          });
      }
    }
	
	function showSpendingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
			var date = [];
			var spendingAmount = [];

            for (var i in data) {

			  date.push(data[i].t_date);
			  
			  if (data[i].t_type == "Spending") {
				spendingAmount.push(data[i].t_amount);
              } else if (data[i].t_type == "Income") {
                spendingAmount.push(null);
              } 
			  
            }
			
            var graphTarget5 = $("#graphSpending");

			var lineGraph3 = new Chart(graphTarget5, {
              type: 'line',
              data: {
                labels: date,
                datasets: [{
                  label: 'Spending',
                  data: spendingAmount,
                  backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                  ],
                  borderColor: [
                    'rgba(255, 99, 132, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              },
			  options: {
				spanGaps: true
			  }
			});
          });
      }
    }
	
	function showSavingGraph() {
      {
        $.post("SelectTransactionData.php",
          function(data) {
			var date = [];
			var incomeAmount = [];

            for (var i in data) {

			  date.push(data[i].t_date);
			  
			  if (data[i].t_type == "Spending") {
				incomeAmount.push(null);
              } else if (data[i].t_type == "Income") {
                incomeAmount.push(data[i].t_amount);
              } 
			  
            }
			
            var graphTarget6 = $("#graphSaving");

			var lineGraph4 = new Chart(graphTarget6, {
              type: 'line',
              data: {
                labels: date,
                datasets: [{
				  label: 'Income',
                  data: incomeAmount,
                  backgroundColor: [
					'rgba(54, 162, 235, 0.2)'
                  ],
                  borderColor: [
                    'rgba(54, 162, 235, 1)'
                  ],
                  hoverBackgroundColor: '#CCCCCC',
                  hoverBorderColor: '#666666'
                }]
              },
			  options: {
				spanGaps: true
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