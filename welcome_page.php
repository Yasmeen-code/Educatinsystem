<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyY</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .hero {
            background-color: #2c3e50;
            color: white;
            padding: 80px 0;
            text-align: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 40px;
        }

        .btn-custom-outline {
            border: 2px solid #3498db;
            color: #3498db;
            padding: 15px 30px;
            margin: 10px;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-custom-outline:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>

<body>

    <header class="hero">
        <div class="container">
            <h1>Welcome to MyY Website!</h1>
            <p class="lead">Empowering learners through knowledge and innovation.</p>
            <a href="stdlogin.php" class="btn btn-custom-outline btn-lg">Login as Student</a>
            <a href="teacherlogin.php" class="btn btn-custom-outline btn-lg">Login as Teacher</a>
            <a href="adminlogin.php" class="btn btn-custom-outline btn-lg">Login as Admin</a>

        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>