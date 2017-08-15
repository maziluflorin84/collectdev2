<?php
function logged_in() {
    return (isset($_SESSION['ID'])) ? true : false;
}

function user_exists($email) {
    global $db;
    $email = sanitize($email);
    $result = $db->prepare("SELECT COUNT(`ID`) FROM `users` WHERE `email` = ?");
    $result->bind_param('s', $email);
    $result->execute();
    $result->bind_result($row);
    while($result->fetch()) {
        return $row == 1 ? true : false;
    }
}

function user_id_from_email($email) {
    global $db;
    $email = sanitize($email);
    $result = $db->prepare("SELECT `ID` FROM `users` WHERE `email` = ?");
    $result->bind_param('s', $email);
    $result->execute();
    $result->bind_result($row);
    while($result->fetch()) {
        return $row;
    }
}

function login($email, $password) {
    global $db;
    $user_id = user_id_from_email($email);

    $email = sanitize($email);
    $password = md5($password);

    $result = $db->prepare("SELECT COUNT(`ID`) FROM `users` WHERE `email` = ? AND `password` = ?");
    $result->bind_param('ss', $email, $password);
    $result->execute();
    $result->bind_result($row);
    while ($result->fetch()) {
        return $row == 1 ? $user_id : false;
    }
}