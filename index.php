<?php
require('db.php');
$showteacher = false;
$showstudent = false;
$teachers = [];
$students = [];

function fetchData($mycon, $table)
{
    $q = "SELECT * FROM $table";
    $stmt = $mycon->prepare($q);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (isset($_POST['teacher'])) {
    $showteacher = true;
    $teachers = fetchData($mycon, 'teacher');
}

if (isset($_POST['student'])) {
    $showstudent = true;
    $students = fetchData($mycon, 'students');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students and Teachers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post" class="mb-4">
            <button type="submit" name="teacher" class="btn btn-primary">View Teachers</button>
            <button type="submit" name="student" class="btn btn-primary">View Students</button>
        </form>

        <?php if ($showstudent) { ?>
            <h2>Student List</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Class</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)) {
                        foreach ($students as $row) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['dob']); ?></td>
                                <td><?php echo htmlspecialchars($row['class']); ?></td>
                                <td>
                                    <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">No students found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="adminaddstd.php" class="btn btn-primary">Add New Student</a>
        <?php } ?>

        <?php if ($showteacher) { ?>
            <h2>Teacher List</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Secret Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($teachers)) {
                        foreach ($teachers as $row) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['snum']); ?></td>
                                <td>
                                    <a href="edit_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_teacher.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No teachers found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="adminAddTeacher.php" class="btn btn-primary">Add New Teacher</a>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>