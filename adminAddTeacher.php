<?php
require('db.php');
$nameErr = $snumErr = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST["name"]);
    $snum = trim($_POST["snum"]);

    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    } else {
        $q = "SELECT COUNT(*) FROM teacher WHERE snum = ?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$snum]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $snumErr = "Secret number already exists.";
        } else {
            $q = "INSERT INTO teacher (name, snum) VALUES (?, ?)";
            $stmt = $mycon->prepare($q);
            $stmt->execute([$name, $snum]);
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
    <title>Add teacher</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin-top: 100px;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Add teacher</h2>
        <form action="" method="POST">
            <?php if ($nameErr || $snumErr) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo htmlspecialchars($nameErr) . '<br>';
                    echo htmlspecialchars($snumErr) . '<br>';
                    ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Secret Number</label>
                <input type="text" class="form-control" id="email" name="snum" placeholder="Enter secret number" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Add new teacher</button>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>