<?php
function recover($email) {
    $email = sanitize($email);

    $first_name = user_first_name(user_id_from_email($email));

    $generated_password = substr(md5(rand(999, 999999)), 0, 14);

    change_password(user_id_from_email($email), $generated_password);

    email($email, 'Your CollectDev password recovery', "Hello " . $first_name . "\nYour new password is: " . $generated_password . "\n\n Please log in and change it!\n\n CollectDev");
}

function update_user($user_id, $update_data) {
    global $db;
    $user_id = (int)$user_id;
    $update = array();
    array_walk($update_data, 'array_sanitize');

    foreach ($update_data as $field=>$data) {
        $update[$field] = '`' . $field . '` = \'' . $data . '\'';
    }

    $updating = implode(', ', $update);

    $stmt = $db->prepare("UPDATE `users` SET $updating WHERE `ID` = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
}

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
    $password = $register_data['password'];
    $register_data['password'] = md5($register_data['password']);

    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'', $register_data) . '\'';

    $stmt = $db->prepare("INSERT INTO `users` ($fields) VALUES ($data)");
    $stmt->execute();
    email($register_data['email'],'Account created on CollectDev!', "Hello " . $register_data['first_name'] . "\n\nYou have just created an account with the following login credentials:\nemail = " . $register_data['email'] . "\npassword = " . $password . "\n\nIf you have not requested an account with this email address, please send us an email at florin.mazilu@info.uaic.ro\n\nHave a great day!\nCollectDev");
}

function user_first_name($user_id) {
    global $db;
    $user_id = (int)$user_id;
    $stmt = $db->prepare("SELECT `first_name` FROM `users` WHERE `ID` = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($first_name);
    while ($stmt->fetch()) {
        return $first_name;
    }
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

function email_exists($email) {
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