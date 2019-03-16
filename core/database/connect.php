<?php
$db = new mysqli('127.0.0.1','collectdev', 'ArduinoManager', 'collectdev');

if($db->connect_errno) {
    die('Sorry, we are having some problems.');
}
