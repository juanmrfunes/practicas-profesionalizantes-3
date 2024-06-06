<?php
// api/get_groups.php

require '../config/db.php';

$sql = "SELECT * FROM `group`";
$result = $conn->query($sql);

$groups = [];
while ($row = $result->fetch_assoc()) {
    $groups[] = $row;
}

echo json_encode($groups);

$conn->close();
