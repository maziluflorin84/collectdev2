<?php
function email($to, $subject, $body) {
    mail($to, $subject, $body, 'From: florin.mazilu@info.uaic.ro');
}

function logged_in_redirect() {
    if (logged_in() === true) {
        header('Location: index.php');
    }
}

function protect_page() {
    if (logged_in() === false) {
        header('Location: protected.php');
        exit();
    }
}


function array_sanitize(&$item) {
    global $db;
    $item = $db->real_escape_string(htmlentities(strip_tags(trim($item)), ENT_QUOTES, 'UTF-8'));
}

function sanitize($data) {
    global $db;
    return $db->real_escape_string(htmlentities(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8'));
}


function output_errors($errors) {
    return '<ul style="color: #ff0000"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}