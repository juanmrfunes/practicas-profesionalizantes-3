<?php
// api/update_user.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$username = $data['username'];
$password = $data['password'];

if (!$userId || !$username || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "UPDATE user SET username = ?, password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $password, $userId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User updated']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
