<?php
session_start();
require('db.php');
$error = "";
$showEmailPasswordForm = false;

if (isset($_POST['snum_submit'])) {
    $snum = trim($_POST['snum']);

    if (empty($snum)) {
        $error = "Secret number is required.";
    } else {
        $q = "SELECT * FROM teacher WHERE snum = ?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$snum]);
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($teacher) {
            session_regenerate_id(true);
            $_SESSION['teacher_id'] = $teacher['id'];
            $showEmailPasswordForm = true;
        } else {
            $error = "Invalid secret number.";
        }
    }
}

if (isset($_POST['login_submit'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $q1 = "SELECT * FROM teacher WHERE email = ?";
        $stmt1 = $mycon->prepare($q1);
        $stmt1->execute([$email]);
        $teacher1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        if (isset($_SESSION['teacher_id'])) {
            $q = "SELECT * FROM teacher WHERE id = ?";
            $stmt = $mycon->prepare($q);
            $stmt->execute([$_SESSION['teacher_id']]);
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($teacher['email']) && empty($teacher['password'])) {
                if (!$teacher1) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $update_q = "UPDATE teacher SET email = ?, password = ? WHERE id = ?";
                    $update_stmt = $mycon->prepare($update_q);

                    if ($update_stmt->execute([$email, $hashedPassword, $_SESSION['teacher_id']])) {
                        header('Location: teacher_dashboard.php');
                        exit;
                    } else {
                        $error = "Failed to save email and password.";
                    }
                } else {
                    $error = "Email already exists. Use another one.";
                }
            } else {
                if ($teacher['email'] === $email && password_verify($password, $teacher['password'])) {
                    session_regenerate_id(true);
                    header('Location: teacher_dashboard.php');
                    exit;
                } else {
                    $error = "Invalid email or password.";
                }
            }
        } else {
            $error = "Session expired. Please start over.";
        }
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
        <?php if (!$showEmailPasswordForm) { ?>
            <h2 class="text-center">Are you a teacher?</h2>
            <form action="" method="POST">
                <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="snum">Secret number</label>
                    <input type="text" class="form-control" id="snum" name="snum" placeholder="Enter your secret number" required>
                </div>
                <button type="submit" name="snum_submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        <?php } else { ?>
            <h2 class="text-center">Login</h2>
            <form action="" method="POST">
                <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login_submit" class="btn btn-primary btn-block">Login</button>
            </form>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>