<?php
function sanitize($data) {
    global $db;
    return $db->real_escape_string(htmlentities(trim($data), ENT_QUOTES, 'UTF-8'));
}