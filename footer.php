<!-- Footer -->
<br/>
<br/>
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script>
    $(document).ready(function(){
        setInterval(_initTimer, 1000);
    });
    function _initTimer(){
        $.ajax({
            url: 'timer.php',
            success: function(data2) {
                data2 = data2.split(':');
                $('#hrs').html(data2[0]);
                $('#mins').html(data2[1]);
                $('#secs').html(data2[2]);
            }
        });
    }
  </script>
</head>
<footer class="bg-dark text-center text-white" style="position: absolute; bottom: 0; width: 100%;">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    <span class="text-white h4">MoneyPlot</span>
    <br/>
      <span id='hrs'>0</span>:<span id='mins'>0</span>:<span id='secs'>0</span>
     <p>Built by Brent Bemiller, Rafeed Ullah, Russel Bryan Reyes, Nalani Bui, and Mitch Kim</p>
  </div>
</footer>