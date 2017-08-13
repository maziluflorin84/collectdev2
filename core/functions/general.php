<?php
function sanitize($data, $db) {
    return mysqli_real_escape_string($db,$data);
}