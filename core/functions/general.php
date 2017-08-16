<?php
function sanitize($data) {
    global $db;
    return $db->real_escape_string(htmlentities(trim($data), ENT_QUOTES, 'UTF-8'));
}

function output_errors($errors) {
    return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}