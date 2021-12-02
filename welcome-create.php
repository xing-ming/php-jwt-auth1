<?php
    include_once("config/database.php");
    include_once("vendor/autoload.php");
    use \Firebase\JWT\JWT;
    include_once("config/cors.php");

    // get request headers
    $authHeader = getallheaders();

    if (isset($authHeader['Authorization']) && $_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $token = $authHeader['Authorization'];
        $token = explode(" ", $token)[1];

        try 
        {
            $key = "YOUR CLOUD BOOKS";
            $decoded = JWT::decode($token, $key, array('HS256'));

            http_response_code(200);
            echo json_encode($decoded);
            die;
        } 
        catch (Exception $e) 
        {
            http_response_code(401);
            echo json_encode(array('message' => 'Please signin.!'));
            die;
        }
    }
    else
    {
        http_response_code(401);
        echo json_encode(array('message' => 'Please signin.!'));
        die;
    }
?>