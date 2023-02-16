<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Realtime Chat App</title>
</head>

<body>
    <div class="wrapper">
        <section class="form login">
            <header>Realtime Chat App</header>
            <form>
                <div class="error-txt"></div>
                <div class="field input">
                    <label for="">Email Address</label>
                    <input type="text" name="email" placeholder="Enter Your Email">
                </div>
                <div class="field input">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Enter Your Password">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Contiue To Chat">
                </div>
                <div class="link">
                    Not yet signed up? <a href="signup.php">Signup now</a>
                </div>
            </form>
        </section>
    </div>
    <script src="pass-show-hide.js"></script>
    <script src="login.js"></script>
</body>

</html>