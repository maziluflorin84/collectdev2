<?php
session_start();

require 'database/connect.php';
require 'functions/users.php';
require 'functions/general.php';

if (logged_in() === true) {
    $session_user_id = $_SESSION['ID'];
    $user_data = user_data($session_user_id, 'first_name', 'last_name', 'email');
    echo 'First Name: ' . $user_data['first_name'] . '<br>';
    echo 'Last Name: ' . $user_data['last_name'] . '<br>';
    echo 'Email: ' . $user_data['email'];
}

$errors = array();