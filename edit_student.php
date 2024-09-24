<?php
require('db.php');
$nameErr = "";
$emailErr = "";
$id = $_GET['id'];
$q = "SELECT * FROM students WHERE id = ?";
$stmt = $mycon->prepare($q);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];


    if (empty($name)) {
        $errors .= '<p class="text-danger">Name is required.</p>';
    } elseif (empty($email)) {
        $errors .= '<p class="text-danger">Email is required.</p>';
    } elseif (empty($dob)) {
        $errors .= '<p class="text-danger">Date of Birth is required.</p>';
    } elseif (empty($class)) {
        $errors .= '<p class="text-danger">Class is required.</p>';
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if (empty($errors) && empty($nameErr) && empty($emailErr)) {
        $q = "SELECT COUNT(*) FROM students WHERE email = ? AND id != ?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$email, $id]);
        $count = $stmt->fetchColumn();

        if ($count) {
            $errors = "Email already exists.";
        } else {
            $q = "UPDATE students SET name = ?, email = ?, dob = ?, class = ?, created_at = NOW() WHERE id = ?";
            $stmt = $mycon->prepare($q);
            $stmt->execute([$name, $email, $dob, $class, $id]);
            header('Location: index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editing</title>
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
        <h2>Edit Student</h2>
        <form action="" method="POST">
            <?php if ($errors || $emailErr || $nameErr) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($errors . $nameErr . $emailErr) ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($student['email']) ?>">
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= htmlspecialchars($student['dob']) ?>">
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <select class="form-control" id="class" name="class">
                    <option value="">Select Class</option>
                    <option value="10A" <?= $student['class'] == "10A" ? "selected" : "" ?>>10A</option>
                    <option value="10B" <?= $student['class'] == "10B" ? "selected" : "" ?>>10B</option>
                    <option value="11A" <?= $student['class'] == "11A" ? "selected" : "" ?>>11A</option>
                    <option value="11B" <?= $student['class'] == "11B" ? "selected" : "" ?>>11B</option>
                    <option value="12A" <?= $student['class'] == "12A" ? "selected" : "" ?>>12A</option>
                    <option value="12B" <?= $student['class'] == "12B" ? "selected" : "" ?>>12B</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>