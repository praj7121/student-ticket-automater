<?php
require_once '../config.php';

// CSV download headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=feedtrack_tickets_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// CSV header row
fputcsv($output, ['Ticket ID', 'Student Name', 'Roll Number', 'Department', 'Category', 'Priority', 'Description', 'Status', 'Submission Date', 'Resolved Date']);

// Fetch all tickets
$result = $conn->query("SELECT * FROM tickets ORDER BY ticket_id ASC");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['ticket_id'],
        $row['student_name'],
        $row['roll_number'],
        $row['department'],
        $row['category'],
        $row['priority'],
        $row['description'],
        $row['status'],
        $row['submission_date'],
        $row['resolved_date'] ?? ''
    ]);
}

fclose($output);
$conn->close();
?>