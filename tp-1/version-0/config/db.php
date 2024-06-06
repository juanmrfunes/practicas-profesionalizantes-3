<?php
// config/db.php

$host = '127.0.0.1';
$db   = 'usergroup.sql';
$user = 'admin';
$pass = 'nimda';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
