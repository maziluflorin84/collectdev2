<?php
$db = new mysqli('localhost','root', '4167mysql', 'collectdev');

if($db->connect_errno) {
    die('Sorry, we are having some problems.');
}
