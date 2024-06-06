<?php
// api/delete_user.php

require '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];

if (!$userId) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

$sql = "DELETE FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'User deleted']);
} else {
    http_response_code(500);
    echo json_encode(['message' => $stmt->error]);
}

$stmt->close();
$conn->close();
