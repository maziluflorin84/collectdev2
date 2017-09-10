<?php
function change_password($user_id, $password) {
    global $db;
    $user_id = (int)$user_id;
    $password = md5($password);

    $stmt = $db->prepare("UPDATE `users` SET `password` = ? WHERE `ID` = ?");
    $stmt->bind_param('si', $password, $user_id);
    $stmt->execute();
}

function register_user($register_data) {
    global $db;
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);

    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'', $register_data) . '\'';

    $stmt = $db->prepare("INSERT INTO `users` ($fields) VALUES ($data)");
    $stmt->execute();
}

function user_data($user_id) {
    global $db;
    $data = array();
    $user_id = (int)$user_id;
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    if ($func_num_args > 1) {
        unset($func_get_args[0]);
        $fields = '`' . implode('`, `', $func_get_args) . '`';
        $stmt = $db->prepare("SELECT $fields FROM `users` WHERE `ID` = ?");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($data['ID'], $data['email'], $data['password'], $data['first_name'], $data['last_name']);
        while ($stmt->fetch()) {
            return $data;
        }
    }
}

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