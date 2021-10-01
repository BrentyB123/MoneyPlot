<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
<body>

<?php

            $type = $_POST['limit'];
            $amount = $_POST['Amount'];
            $date = $_POST['date'];
			
            //connect to db
            $db_connection = mysqli_connect("studentdb-maria.gl.umbc.edu", "rullah1", "rullah1", "rullah1");
			
			// Check connection
            if ($db_connection->connect_error) {
                die("Connection failed: " . $db_connection->connect_error);
            }
			
			//sql insert
            $sql_insert = "Insert into spending (s_limit, s_amount, s_date) VALUES ('$type', $amount, '$date')";

            //send insert to db
            if ($db_connection->query($sql_insert) === TRUE) {
                echo "New limit added";
            } else {
                echo "Error: " . $sql_insert . "<br>" . $db_connection->error;
            }
            
            //close connection
            $db_connection->close();

        ?>

        <br/>
        
        <a href="Goals.php">Back to goals</a>

    </body>
</html>