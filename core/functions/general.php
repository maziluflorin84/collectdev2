<?php
function sanitize($data, $db) {
    return $db->real_escape_string(trim($data));
}