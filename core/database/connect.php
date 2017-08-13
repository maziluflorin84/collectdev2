<?php
$db = new mysqli('localhost','root', '4167mysql', 'collect_devices');

if($db->connect_errno) {
    die('Sorry, we are having some problems.');
}
