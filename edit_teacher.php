<?php
require('db.php');
$nameErr = "";
$snumErr = "";
$id = $_GET['id'];
$q = "SELECT * FROM teacher WHERE id = ?";
$stmt = $mycon->prepare($q);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $snum = $_POST['snum'];



    if (empty($name)) {
        $nameErr .= '<p class="text-danger">Name is required.</p>';
    } elseif (empty($email)) {
        $snumErr .= '<p class="text-danger">Secret number is required.</p>';
    }
    if (empty($errors) && empty($nameErr) && empty($emailErr)) {
        $q = "SELECT COUNT(*) FROM teacher WHERE snum = ? AND id != ?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$snum, $id]);
        $count = $stmt->fetchColumn();

        if ($count) {
            $snumErr = "secret number already exists.";
        } else {
            $q = "UPDATE teacher SET name = ?, snum = ? WHERE id = ?";
            $stmt = $mycon->prepare($q);
            $stmt->execute([$name, $snum, $id]);
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
            <?php if ($nameErr || $snumErr) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($nameErr . $snumErr) ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($student['name']) ?>">
            </div>
            <div class="form-group">
                <label for="snum">Secret Number</label>
                <input type="text" class="form-control" name="snum" value="<?= htmlspecialchars($student['snum']) ?>">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>