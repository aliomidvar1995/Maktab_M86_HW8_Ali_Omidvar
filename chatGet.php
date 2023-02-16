<?php
session_start();
$config = require_once "config.php";

if(!empty($config['type']) && $config['type'] == 'json') {
    $data = file_get_contents('users.json');
    $data_array = json_decode($data, true);

    $message = file_get_contents('messages.json');
    $message_array = json_decode($message, true);
}

if(!empty($config['type']) && $config['type'] == 'pdo') {
    $output = "";
    $dsn = "mysql:host=localhost;dbname=chat";
    $conn = new PDO($dsn, 'root', '');
    $sql1 = "SELECT * FROM users";
    $sql2 = "SELECT * FROM messages";
    $stmt1 = $conn->prepare($sql1);
    $stmt2 = $conn->prepare($sql2);
    $stmt1->execute();
    $stmt2->execute();
    $data_array = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $message_array = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
if(!empty($message_array)){
    $output = "";
    for($i=0; $i<count($message_array);$i++){
        if($message_array[$i]['user_id'] == $_SESSION['user_id']){
            $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>' . $message_array[$i]['message'] . '</p>
                            </div>
                        </div>';
        } else {
            for ($j = 0; $j < count($data_array); $j++) {
                if ($message_array[$i]['user_id'] == $data_array[$j]['user_id']) {
                    $image = $data_array[$j]['image'];
                    $fname = $data_array[$j]['fname'];
                    $lname = $data_array[$j]['lname'];
                    $output .= '<div class="chat incoming">
                                    <img src="images/' . $image . '" alt="">
                                    <div class="details">
                                        <h5>'.$fname.' '.$lname.'</h5>
                                        <p>' . $message_array[$i]['message'] . '</p>
                                    </div>
                                </div>';
                }
            }
        }
    }
    echo $output;
}

?>