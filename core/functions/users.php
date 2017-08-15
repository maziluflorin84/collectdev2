<?php
//include 'core/database/connect.php';
function user_exists($email, $db) {
    $email = sanitize($email,$db);
    $result = $db->prepare("SELECT `ID` FROM `users` WHERE `email` = ?");
    $result->bind_param('s', $email);
    $result->execute();
    $result->store_result();
    $row = $result->num_rows();
    return $row == 1 ? true : false;
}