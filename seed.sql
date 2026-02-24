-- FeedTrack Database Setup
-- Import this via phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS feedtrack;
USE feedtrack;

-- Tickets table
CREATE TABLE IF NOT EXISTS tickets (
  ticket_id VARCHAR(10) PRIMARY KEY,
  student_name VARCHAR(100),
  roll_number VARCHAR(20),
  department VARCHAR(100),
  category VARCHAR(50),
  priority VARCHAR(10),
  description TEXT,
  status VARCHAR(20) DEFAULT 'Open',
  submission_date DATE,
  resolved_date DATE DEFAULT NULL
);

-- Meeting minutes table
CREATE TABLE IF NOT EXISTS meeting_minutes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  meeting_date DATE,
  chaired_by VARCHAR(100),
  attendees TEXT,
  generated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  content TEXT
);

-- Monthly reports table
CREATE TABLE IF NOT EXISTS monthly_reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  report_month VARCHAR(20),
  total_tickets INT,
  resolved INT,
  resolution_rate DECIMAL(5,2),
  avg_resolution_days DECIMAL(5,2),
  alerts_sent INT,
  generated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Sample ticket data
INSERT INTO tickets (ticket_id, student_name, roll_number, department, category, priority, description, status, submission_date) VALUES
('TKT-001', 'Deepti Kalakoti', '24WU0101068', 'Computer Science', 'IT Issue', 'High', 'Wi-Fi connectivity drops frequently in Block C labs during afternoon sessions.', 'Open', '2026-02-10'),
('TKT-002', 'Daksha Reddy', '24WU0101081', 'Business', 'Classroom Issue', 'Medium', 'Projector in Room 202 has color distortion, making presentations unreadable.', 'In-Progress', '2026-02-12'),
('TKT-003', 'Hansika', '24WU0101110', 'Design', 'Infrastructure', 'Low', 'Water cooler on 3rd floor is not working since last week.', 'Resolved', '2026-02-14'),
('TKT-004', 'Pranav', '24WU0101087', 'Computer Science', 'Admin Request', 'Medium', 'Request for new student ID card — old card damaged.', 'Verified', '2026-02-15'),
('TKT-005', 'Prajwal Patil', '24WU0101101', 'Computer Science', 'IT Issue', 'High', 'Software license for Adobe Creative Suite expired on lab machines.', 'Open', '2026-02-16'),
('TKT-006', 'Deepti Kalakoti', '24WU0101068', 'Liberal Arts', 'Classroom Issue', 'Low', 'Broken chair in seminar hall A needs replacement.', 'In-Progress', '2026-02-17'),
('TKT-007', 'Daksha Reddy', '24WU0101081', 'Architecture', 'Infrastructure', 'High', 'Leaking ceiling in Architecture Studio causing water damage to student work.', 'Open', '2026-02-18'),
('TKT-008', 'Hansika', '24WU0101110', 'Law', 'Admin Request', 'Medium', 'Library access card not scanning properly at the entrance gate.', 'Resolved', '2026-02-20'),
('TKT-009', 'Pranav', '24WU0101087', 'Business', 'IT Issue', 'High', 'ERP portal login shows error 500 when accessing course registration.', 'Open', '2026-02-21'),
('TKT-010', 'Prajwal Patil', '24WU0101101', 'Design', 'Infrastructure', 'Low', 'Restroom in Design block requires maintenance — broken door latch.', 'In-Progress', '2026-02-22');
