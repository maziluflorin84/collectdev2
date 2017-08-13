<?php
include "core/init.php";

if (empty($_POST) === false) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "You need to enter an email or password.";
    } elseif (user_exists($email,$db) === false) {
        $errors[] = "We can\'t find that email";
    } else {
        echo "Done";
    }
}