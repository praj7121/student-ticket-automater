<?php
require_once '../config.php';
header('Content-Type: application/json');

// Dashboard statistics
$stats = [];

// Total tickets
$result = $conn->query("SELECT COUNT(*) as total FROM tickets");
$stats['total'] = $result->fetch_assoc()['total'];

// Resolved (Resolved + Verified)
$result = $conn->query("SELECT COUNT(*) as resolved FROM tickets WHERE status IN ('Resolved', 'Verified')");
$stats['resolved'] = $result->fetch_assoc()['resolved'];

// In Progress
$result = $conn->query("SELECT COUNT(*) as in_progress FROM tickets WHERE status = 'In-Progress'");
$stats['in_progress'] = $result->fetch_assoc()['in_progress'];

// Overdue (Open + older than 5 days)
$result = $conn->query("SELECT COUNT(*) as overdue FROM tickets WHERE status = 'Open' AND submission_date < DATE_SUB(CURDATE(), INTERVAL 5 DAY)");
$stats['overdue'] = $result->fetch_assoc()['overdue'];

// Recent tickets (last 5)
$result = $conn->query("SELECT * FROM tickets ORDER BY submission_date DESC, ticket_id DESC LIMIT 5");
$stats['recent'] = [];
while ($row = $result->fetch_assoc()) {
    $stats['recent'][] = $row;
}

// Department breakdown
$result = $conn->query("SELECT department, COUNT(*) as count FROM tickets GROUP BY department ORDER BY count DESC");
$stats['departments'] = [];
while ($row = $result->fetch_assoc()) {
    $stats['departments'][] = $row;
}

echo json_encode($stats);
$conn->close();
?>