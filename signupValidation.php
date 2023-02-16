<?php
session_start();

$config = require_once "config.php";



$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];



if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!empty($data_array)) {
            for ($i = 0; $i < count($data_array); $i++) {
                if ($email == $data_array[$i]['email']) {
                    echo "$email already exists";
                    exit();
                }
            }
        }
    } else {
        echo "$email is not a valid email";
        exit();
    }
    if (isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name'];
        $img_type = $_FILES['image']['type'];
        $img_tmp_name = $_FILES['image']['tmp_name'];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        $extentions = ['jpg', 'png', 'jpeg'];
        if (in_array($img_ext, $extentions) === true) {
            $time = time();
            $new_img_name = $time . $img_name;

            if (move_uploaded_file($img_tmp_name, "images/" . $new_img_name)) {
                $status = 'Active now';
                $random_id = rand(time(), 10000000);
                if(!empty($config['type']) && $config['type'] == 'json') {
                    $data = file_get_contents('users.json');
                    $data_array = json_decode($data, true);
                    $data_array[] = [
                        'fname'=> $_POST['fname'],
                        'lname' => $_POST['lname'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'image' => $new_img_name,
                        'user_id' => $random_id
                    ];
                    $_SESSION['user_id'] = $random_id;
                    $data_array = json_encode($data_array, JSON_PRETTY_PRINT);
                    file_put_contents('users.json', $data_array);
                    echo "success";
                }
                if(!empty($config['type']) && $config['type'] == 'pdo') {
                    $dsn = "mysql:host=localhost;dbname=chat";
                    $conn = new PDO($dsn, 'root', '');
                    $sql1 = "INSERT INTO users (first_name, last_name, email, password, image)
                    VALUES (:first_name, last_name, email, password, image)";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->execute([
                        'first_name' => $_POST['fname'],
                        'last_name' => $_POST['lname'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'image' => $new_img_name
                    ]);
                    $sql2 = "SELECT * FROM users WHERE email = :email";
                    $stmt2 = $conn->prepare($select);
                    $stmt2->execute([
                        'email' => $_POST['email']
                    ]);
                    $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user_id'] = $user['user_id'];
                    echo "success";
                }
            } else {
                echo 'something went wrong';
            }
        } else {
            echo 'please select an image jpg, png, jpeg';
        }
    } else {
        echo "please select an image file";
    }
} else {
    echo "All input fields are required";
}
?>