<?php
// api/get_users.php

require '../config/db.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
