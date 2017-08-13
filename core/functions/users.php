<?php
//include 'core/database/connect.php';
function user_exists($email, $db) {
    $email = sanitize($email,$db);
    $result = $db->query("SELECT COUNT(`ID`) FROM `users` WHERE `email` = '$email'");
    $row = $result->fetch_row();
    return $row[0] == 1 ? true : false;
}