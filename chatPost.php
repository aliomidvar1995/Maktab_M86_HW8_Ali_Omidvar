<?php
session_start();
$config = require_once "config.php";
if(!empty($config['type']) && $config['type'] == 'json') {
    $message = file_get_contents('messages.json');
    $message_array = json_decode($message, true);

    $input = [
        'user_id' => $_SESSION['user_id'],
        'message' => $_POST['message']
    ];
    $message_array[] = $input;
    $message_array = json_encode($message_array, JSON_PRETTY_PRINT);
    file_put_contents('messages.json', $message_array);
}
if(!empty($config['type']) && $config['type'] == 'pdo') {
    $dsn = "mysql:host=localhost;dbname=chat";
    $conn = new PDO($dsn, 'root', '');
    $sql = "INSERT INTO messages (message, user_id)
    VALUES (:message, :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'message' => $_POST['message'],
        'user_id' => $_SESSION['user_id']
    ]);
}

?>