<?php
session_start();
$config = require_once "config.php";

$email = $_POST['email'];
$password = $_POST['password'];

if(!empty($config['type']) && $config['type'] == 'json') {
    $data = file_get_contents('users.json');
    $data_array = json_decode($data, true);
}

if(!empty($config['type']) && $config['type'] == 'pdo') {
    $dsn = "mysql:host=localhost;dbname=chat";
    $conn = new PDO($dsn, 'root', '');
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($email) && !empty($password)) {
    if (!empty($data_array)) {
        for ($i = 0; $i < count($data_array); $i++) {
            if ($email === $data_array[$i]['email'] && $password === $data_array[$i]['password']) {
                $_SESSION['user_id'] = $data_array[$i]['user_id'];
                echo "success";
            }
        }
        if(!isset($_SESSION['user_id'])){
            echo "email or password is incorrect";
        }
    }
} else {
    echo "All fields are required";
}
