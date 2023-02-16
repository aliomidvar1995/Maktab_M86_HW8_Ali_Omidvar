<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>Realtime Chat App</title>
</head>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                $config = require_once "config.php";

                if(!empty($config['type']) && $config['type'] == 'json') {
                    $data = file_get_contents('users.json');
                    $data_array = json_decode($data, true);
                    for($i=0;$i<count($data_array);$i++){
                        if($data_array[$i]['user_id'] === $_SESSION['user_id']){
                            $fname = $data_array[$i]['fname'];
                            $lname = $data_array[$i]['lname'];
                            $image = $data_array[$i]['image'];
                        }
                    }
                }
                if(!empty($config['type']) && $config['type'] == 'pdo') {
                    $dsn = "mysql:host=localhost;dbname=chat";
                    $conn = new PDO($dsn, 'root', '');
                    $sql = "SELECT * FROM users WHERE user_id = :user_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        'user_id' => $_SESSION['user_id']
                    ]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $fname = $user['first_name'];
                    $lname = $user['last_name'];
                    $image = $user['image'];
                }
                ?>
                <a href="logout.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="images/<?php echo $image;?>" alt="">
                <div class="details">
                    <span><?php echo $fname . ' ' . $lname;?></span>
                </div>
            </header>
            <div class="chat-box">
            </div>
            <form action="" class="typing-area">
                <input type="text" name="message" class="input-field" placeholder="type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
    <script src="chat.js"></script>
</body>

</html>