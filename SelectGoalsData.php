<?php

    header('Content-Type: application/json');

    //connection to db
    $db_connection = mysqli_connect("studentdb-maria.gl.umbc.edu", "rullah1", "rullah1", "rullah1");

    // Check connection
    if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
    }

    $sql_select = "SELECT s_limit, s_amount, s_date FROM spending";
    $result = $db_connection->query($sql_select);

    $data = array();

    if ($result->num_rows > 0) {
        // output data of each row
        foreach ($result as $row) {
            $data[] = $row;
        }
    } 

    $result->close();

    $db_connection->close();

    echo json_encode($data);
?>