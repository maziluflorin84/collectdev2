<?php
function array_sanitize(&$item) {
    global $db;
    $item = $db->real_escape_string(htmlentities(trim($item), ENT_QUOTES, 'UTF-8'));
}

function sanitize($data) {
    global $db;
    return $db->real_escape_string(htmlentities(trim($data), ENT_QUOTES, 'UTF-8'));
}

function output_errors($errors) {
    return '<ul style="color: #ff0000"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}