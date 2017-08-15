<?php
function sanitize($data, $db) {
    return $db->real_escape_string(htmlentities(trim($data), ENT_QUOTES, 'UTF-8'));
}