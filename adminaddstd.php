<?php
require('db.php');
$nameErr = $emailErr = $passwordErr = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST["dob"];
    $class = $_POST["class"];

    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } elseif ($_POST['password'] !== $_POST['pswcon']) {
        $passwordErr = "Passwords do not match.";
    } elseif (strlen($_POST['password']) < 8) {
        $passwordErr = "Password must be at least 8 characters long.";
    } else {
        $q = "SELECT COUNT(*) FROM students WHERE email = ?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $emailErr = "Email already exists.";
        } else {
            $q = "INSERT INTO students (name, email,password, dob, class, created_at) VALUES (?, ?,?, ?, ?, NOW())";
            $stmt = $mycon->prepare($q);
            $stmt->execute([$name, $email, $password, $dob, $class]);
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
    <title>Sign Up</title>
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
        <h2 class="text-center">Sign Up</h2>
        <form action="" method="POST">
            <?php if ($nameErr || $emailErr || $passwordErr) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo htmlspecialchars($nameErr) . '<br>';
                    echo htmlspecialchars($emailErr) . '<br>';
                    echo htmlspecialchars($passwordErr);
                    ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password" required>
            </div>
            <div class="mb-3">
                <label for="password">Confirm Password</label>
                <input type="password" name="pswcon" class="form-control" id="exampleInputPassword2" placeholder="Confirm your password" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <select class="form-control" id="class" name="class" required>
                    <option value="">Select Class</option>
                    <option value="10A">10A</option>
                    <option value="10B">10B</option>
                    <option value="11A">11A</option>
                    <option value="11B">11B</option>
                    <option value="12A">12A</option>
                    <option value="12B">12B</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Up</button>
        </form>
        <p class="text-center mt-3">
            Already have an account? <a href="stdlogin.php">Login</a>
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>