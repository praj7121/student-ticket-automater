<?php
require_once '../config.php';
header('Content-Type: application/json');

// Build query with optional filters
$where = [];
$params = [];
$types = '';

if (!empty($_GET['status'])) {
    $where[] = 'status = ?';
    $params[] = $_GET['status'];
    $types .= 's';
}
if (!empty($_GET['category'])) {
    $where[] = 'category = ?';
    $params[] = $_GET['category'];
    $types .= 's';
}
if (!empty($_GET['priority'])) {
    $where[] = 'priority = ?';
    $params[] = $_GET['priority'];
    $types .= 's';
}

$sql = "SELECT * FROM tickets";
if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY submission_date DESC, ticket_id DESC";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$tickets = [];
while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
}

echo json_encode($tickets);
$conn->close();
?>