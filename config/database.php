<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new PDO("mysql:host=$servername;dbname=cloud_book", $username, $password);

    // try 
    // {
    //     $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
        
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     echo "Connected successfully";
    // } 
    // catch(PDOException $e) 
    // {
    //     echo "Connection failed: " . $e->getMessage();
    // }
?>