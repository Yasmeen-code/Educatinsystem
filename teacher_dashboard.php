<?php
require('db.php');
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: teacherlogin.php');
    exit;
}

$q = " SELECT * FROM teacher WHERE id=?";
$stmt = $mycon->prepare($q);
$stmt->execute([$_SESSION['teacher_id']]);

$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
$teacherName = $teacher['name'];

$q = "SELECT * FROM students ";

$stmt = $mycon->prepare($q);

$stmt->execute();

$students = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $students[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
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
        <h1>Welcome,Mr <?php echo htmlspecialchars($teacherName); ?>!</h1>

        <br>

        <h2>Students</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td>
                            <a href="view_student.php?id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm">View</a>
                            <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
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