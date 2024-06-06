<?php
// api/get_actions.php

require '../config/db.php';

$sql = "SELECT * FROM action";
$result = $conn->query($sql);

$actions = [];
while ($row = $result->fetch_assoc()) {
    $actions[] = $row;
}

echo json_encode($actions);

$conn->close();
