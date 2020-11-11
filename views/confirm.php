<?php

/* 
 * 2019, Jordi Serra Sanchez.
 * 
 * NOTICE OF LICENSE
 * 
 * DISCLAIMER
 * 
 * Jordi Serra Sanhcez <jordi@serraperez.cat>
 * Copyright (c),  2019 Jordi Serra Sanchez
 * License url  http://www.serraperez/licenses/
 */
    require_once "functions.php";
    function redirect () {
        header('Loation: register.php');
        exit();
    }
    if (!isset($_GET['email']) ||!isset($_GET['name']) ||!isset($_GET['token'])) {
        redirect();
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SCHEMA);
        $email = $conn->real_escape_string($_GET['email']);
        $name = $conn->real_escape_string($_GET['name']);
        $token = $conn->real_escape_string($_GET['token']);
        $sql = $conn->query("SELECT id, password FROM users WHERE email='$email' AND token='$token' AND isEmailConfirmed=0");
        if ($sql->num_rows > 0) {
            $conn->query("UPDATE users SET isEmailConfirmed=1, token='' where email='$email'");
            $subject = '';
            $subject  = "Account Activated!!!";

            $body = '';
            $body = "Your Account has been activated. Click <a href='".HOST."login.php'>here</a> to log in.<br><br>MyFramework Administrator";
            $ret = sendEmail(Array($email,$name), $subject, $body, false);
            
            if ($ret[0]) {
                echo 'Your email has been verified! You can log in now!<br><br>';
                echo "Click <a href='".HOST."login.php'> here</a> to Log In.";
            }
            else 
                $msg = "Something wrong happened! Please try again! ". $ret[1];
            
        } else
            redirect();
    }