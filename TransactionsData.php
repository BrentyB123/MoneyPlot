<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        
        <?php

            $date = $_POST['date'];
            $description = $_POST['description'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $type = $_POST['type'];

            //connect to db
            $db_connection = mysqli_connect("studentdb-maria.gl.umbc.edu", "rullah1", "rullah1", "rullah1");

            // Check connection
            if ($db_connection->connect_error) {
                die("Connection failed: " . $db_connection->connect_error);
            }

            //sql insert
            $sql_insert = "INSERT INTO trans (t_desc, t_amount, t_cat, t_date, t_type) VALUES ('$description', $amount, '$category', '$date', '$type')";

            //send insert to db
            if ($db_connection->query($sql_insert) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql_insert . "<br>" . $db_connection->error;
            }
            
            //close connection
            $db_connection->close();

        ?>

        <br/>
        
        <a href="Transactions.php">Back to transactions</a>

    </body>
</html>