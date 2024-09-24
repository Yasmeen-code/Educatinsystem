<?php
require('db.php');
$error = "";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $q = "SELECT * FROM students WHERE email = ?";
    $stmt = $mycon->prepare($q);
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        $error = "Email not found.";
    } elseif ($student && password_verify($password, $student['password'])) {
        session_start();
        $_SESSION['student_id'] = $student['id'];
        header('Location: student_dashboard.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <form action="" method="POST">
            <?php if ($error) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo htmlspecialchars($error);
                    ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required> 
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required> 
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center mt-3">
            <a href="#">Forgot Password?</a>
        </p>
        <p class="text-center">
            Don't have an account? <a href="add_student.php">Sign up</a>
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>