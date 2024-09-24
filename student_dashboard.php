<?php
require('db.php');
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: stdlogin.php');
    exit;
}

$q = "SELECT * FROM students WHERE id=?";
$stmt = $mycon->prepare($q);
$stmt->execute([$_SESSION['student_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
$studentName = $student['name'];

$classSchedule = [
    ["subject" => "Math", "time" => "9:00 AM - 10:00 AM"],
    ["subject" => "Science", "time" => "10:15 AM - 11:15 AM"],
    ["subject" => "History", "time" => "11:30 AM - 12:30 PM"],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-container {
            padding: 30px;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($studentName); ?>!</h1>
        <br>
        <h2>Class Schedule</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classSchedule as $class) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['subject']); ?></td>
                        <td><?php echo htmlspecialchars($class['time']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>