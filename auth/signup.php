<?php
    include_once("../config/database.php");
    include_once("../config/cors.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $data = json_decode(file_get_contents("php://input"));

        $fname = $data->firstname;
        $lname = $data->lastname;
        $email = $data->email;
        $password = $data->password;

        $sqlGet = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $stmtGet = $conn->prepare($sqlGet);
        $stmtGet->bindValue(":email", $email);
        $stmtGet->execute();
        $row = $stmtGet->fetch(PDO::FETCH_ASSOC);

        if ($row['num'] > 0) 
        {
            http_response_code(400);
            echo json_encode(array('message' => 'Email already exists.!'));
            die;
        }
        else
        {
            $pass = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
            
            $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":firstname", $fname);
            $stmt->bindValue(":lastname", $lname);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":password", $pass);
            $result = $stmt->execute();
    
            if ($result) 
            {
                http_response_code(201);
                echo json_encode(array('message' => 'Thank you for registering with us.'));
                die;
            }
            else
            {
                http_response_code(500);
                echo json_encode(array('message' => 'Internal Server error.!'));
                die;
            }
        }
    }
    else
    {
        http_response_code(403);
        echo json_encode(array('message' => 'Please contact our consultants.!'));
        die;
    }
?>