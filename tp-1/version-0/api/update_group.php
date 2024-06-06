<?php
// api/update_group.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$groupId = $data['groupId'];
$groupName = $data['groupName'];

if (!$groupId || !$groupName) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "UPDATE `group` SET name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $groupName, $groupId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Group updated']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
