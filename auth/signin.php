<?php
    include_once("../config/database.php");
    include_once("../vendor/autoload.php");
    use \Firebase\JWT\JWT;
    include_once("../config/cors.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $data = json_decode(file_get_contents("php://input"));

        $email = $data->email;
        $password = $data->password;

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) 
        {
            http_response_code(400);
            echo json_encode(array('message' => 'Invalid credentials.!'));
            die;
        }
        else
        {
            $validPassword = password_verify($password, $user["password"]);

            if ($validPassword) 
            {
                $key = "YOUR CLOUD BOOKS";

                $payload = array(
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname']
                );

                $token = JWT::encode($payload, $key);
                http_response_code(200);
                echo json_encode(array('token' => $token));
                die;
            }
            else
            {
                http_response_code(400);
                echo json_encode(array('message' => 'Invalid credentials.!'));
                die;  
            }
        }
    }
?>