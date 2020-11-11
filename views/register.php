<?php
    require_once "functions.php";
    
    $msg  = "";

    if (isset($_POST['submit'])) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SCHEMA);
        $name  = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $cPassword = $conn->real_escape_string($_POST['cPassword']);
        
        if ($name == "" || $email == "" || $password == "") // si els camps estan en blanc
                $msg = "Please Check your inputs";
        else {
            if ($password != $cPassword)  // si els passwords son diferents
                $msg  = "Please Check Your Password";
            else {
                $sql = $conn->query("SELECT id FROM users WHERE email='$email'");
                if ($sql->num_rows > 0) 
                    $msg = "Email already exists in the database";
                else {
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789!$/()*';
                    $token = str_shuffle($token);
                    $token = substr($token,0,10);
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $conn->query("INSERT INTO users (name,email,password,token,idEmailConfirmed) VALUES ('$name','$email','$hashedPassword','$token',0)");

                    $subject = '';
                    $subject  = "Please verify email!";

                    $body = '';
                    $body = "Please click on the link below: <br><br><a href='".HOST."confirm.php?email=$email&name=$name&token=$token'>Click here</a><br><br><b>myFramework Administrator</b>";

                    $adminemail = "myframework@serraperez.cat";
                    $ret = sendEmail(array($adminemail,$name), $subject, $body, false);
                    if ($ret[0])
                        $msg = "You have registered! The administrator will activate your account !!! Please wait and verify your email!";
                    else
                        $msg = "Something wrong happened! Please try again! ". $ret[1];
                }
            }
        }
            
    }
?>
<!DOCTYPE html>
<!--
2019, Jordi Serra Sanchez.

NOTICE OF LICENSE

DISCLAIMER

Jordi Serra Sanhcez <jordi@serraperez.cat>
Copyright (c),  2019 Jordi Serra Sanchez
License url  http://www.serraperez/licenses/
--><html>
    <head>
        <meta charset="UTF-8">
        <title>Password Hashing Register</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="margin-top: 100px;">
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-3" align="center">
                    <img src="images/logo.png"><br><br>
                    <?php if ($msg != "") echo $msg ."<br><br>"; ?>
                    <form method="post" action="register.php">
                        <input class="form-control" minlenght="3" name="name" placeholder="Name..."><br>
                        <input class="form-control" name="email" type="email" placeholder="Email..."><br>
                        <input class="form-control" minlenght="5" name="password" type="password" placeholder="Password..."><br>
                        <input class="form-control" minlenght="5" name="cPassword" type="password" placeholder="Confirm Password..."><br>
                        <input class="btn btn-primary" name="submit" type="submit" value="Register..."><br>
                    </form>
                </div>
            </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
