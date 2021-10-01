
<!-- 
  index.html

  The homepage of the project.

  Created by Rafeed Ullah

  Testing
 -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Moneyplot | Home</title>

    <!-- CSS links -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
      crossorigin="anonymous"
    />
    <!-- Custom Stylesheet -->
    <link
      href="stylesheets/style.css"
      rel="stylesheet"
    />
    <link
    href="stylesheets/style - rafeed.css"
    rel="stylesheet"
  />

    <!-- Google Roboto Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet"/>


    <style type="text/css">
      p.rightclear{
        clear:right;
      }
      p.clear{
        clear: both;
      }
    </style>

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
        
        <p><img class="logoimage" src="images/Homepage Images/logo.png" alt="logo.png"></p>
        
        <p class="lead">
          Take control of your moola.
        </p>
        
        <!-- Button Row Begins-->
          
        <div class="container">
          <div class="row">
            
            <div class="col-sm-1">
            </div>

            <div class="col-sm-3">
              <a href="Transactions.php"><button type="button" class="btn btn-outline-success btn-lg">Add Transactions</button></a>
            </div>


            <div class="col-sm-2">
              <a href="Goals.php"><button type="button" class="btn btn-outline-success btn-lg">View Limits</button></a>
            </div>

            <div class="col-sm-4">
            </div>

            <div class="col-sm-1">
              <a href="Learn.php"><button type="button" class="btn btn-primary btn-lg">Learn</button></a>
            </div>

            <div class="col-sm-1">
            </div>

          </div>
          <!-- Button Row Ends-->
          
          <div class="row">
            </br>
          </div>
          <div class="row">

           <!-- Graph Column Begins -->
            <div class="col-8">
              <p>
                <a href="Analytics.php"><button type="button" class="btn btn-danger btn-lg">Spendings</button></a>
              </p>

              <p class="clear"></p>
              
              <p>
                <div class="graphcard" style="width: 50rem">
                  <div class="graph-content">
                    <div id="chart-container">
                      <canvas id="spendingCanvas" height="100"></canvas>
                    </div>
                  </div>
                    
                  <div class="graph-details">
                     <div class="back-text">
                        This is your spending history </br> for the last 30 days
                     </div>
                  </div>
                </div>
              </p>

              <p class="clear"></p>

              <p>
                <a href="Analytics.php"><button type="button" class="btn btn-success btn-lg">Savings</button></a>
              </p>

              <p class="clear"></p>

              <p>
                <div class="graphcard" style="width: 50rem">
                  <div class="graph-content">
                    <div id="chart-container">
                      <canvas id="savingsCanvas" height="100"></canvas>
                    </div>
                  </div>
                    
                  <div class="graph-details">
                     <div class="back-text">
                       This is your savings history </br> for the last 30 days
                     </div>
                  </div>
                </div>
              </p>

              <p class="clear"></p>
            </div>
            <!-- Graph Column Ends -->



            <!-- Learn Content Column -->
            <div class="col-4">

                <div class="newscard" style="width: 18rem;">
                  <img class="card-img-top" src="images/Homepage Images/grahammillionairetax.jpg" alt="grahammillionairetax">
                  <div class="card-body">
                    <p class="card-text">
                      <a href="https://www.youtube.com/watch?v=btUWj4HSGyg">My Thoughts On The Millionaire Tax </br> by Graham Stephen</a></p>
                  </div>
                </div>
              </p>

              <p class="rightclear"> </p>

              <p>
                <div class="newscard" style="width: 18rem;">
                  <img class="card-img-top" src="images/Homepage Images/brianjungccguide.jpg" alt="brianjungccguide">
                  <div class="card-body">
                    <p class="card-text">
                      <a href="https://www.youtube.com/watch?v=DI16evt55rU&t=2466s">The beginner to expert credit card guide video for 2021 </br> by Brian Jung</a></p>
                  </div>
                </div>
              </p>

              <p class="rightclear"> </p>

              <p>
                <div class="newscard" style="width: 18rem;">
                  <img class="card-img-top" src="images/Homepage Images/ladiesgetpaid.jpg" alt="ladiesgetpaid">
                  <div class="card-body">
                    <p class="card-text">
                      <a href="https://www.wsj.com/articles/how-to-get-women-to-start-talking-about-personal-finance-11615569845"> How to Get Women to Start Talking About Personal Finance </br> Claire Wasserman, founder of Ladies Get Paid, on what women on her platform want to know </a>
                    </p>
                  </div>
                </div>
              </p>

              <p class="rightclear"> </p>
            </div>
            <!-- Learn Content Column Ends-->
          </div>
        </div>
      </div>
    </main>


    <script>
      $(document).ready(function() {
        showGraph1();
        showGraph2();
      });

      function showGraph1() {
        {
          $.post("SelectTransactionData.php",
            function(data) {
              //for testing purposes
              console.log(data);

              //initialization of variables
              var date = [];
              var amount = [];
              var type = [];

              for (var i in data) {
                //push data from php file and put it into a javascript variable
                if (data[i].t_type == "Spending"){
                  date.push(data[i].t_date); 
                  amount.push(data[i].t_amount);
                  type.push(data[i].t_type);
                }
              }

              var graphTarget = $("#spendingCanvas");

              var lineGraph = new Chart(graphTarget, {
                type: 'line',
                data: {
                  labels: date,
                  datasets: [{
                    label: 'Spending History',
                    data: amount,
                    backgroundColor:'#FF9A9A',
                    borderColor: '#ED2424',
                    hoverBackgroundColor: 'FF9494',
                    hoverBorderColor: '#FF0000'
                  }]
                }
              });
            });
        }
      }

      function showGraph2() {
        {
          $.post("SelectTransactionData.php",
            function(data) {
              //for testing purposes
              console.log(data);

              //initialization of variables
              var date = [];
              var amount = [];
              var type = [];

              for (var i in data) {
                //push data from php file and put it into a javascript variable
                if (data[i].t_type == "Income"){
                  date.push(data[i].t_date); 
                  amount.push(data[i].t_amount);
                  type.push(data[i].t_type);
                }
              }

              var graphTarget = $("#savingsCanvas");

              var lineGraph = new Chart(graphTarget, {
                type: 'line',
                data: {
                  labels: date,
                  datasets: [{
                    label: 'Savings History',
                    data: amount,
                    backgroundColor:'#93E9BE',
                    borderColor: '#009C32',
                    hoverBackgroundColor: '#43EE71',
                    hoverBorderColor: '09742B'
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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>

  </body>
</html>