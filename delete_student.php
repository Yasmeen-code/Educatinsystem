<?php
require("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['yes'])) {
        $q = "DELETE FROM students WHERE id=?";
        $stmt = $mycon->prepare($q);
        $stmt->execute([$id]);
        header('Location: index.php');
        exit;
    } elseif (isset($_POST['no'])) {
        header('Location: index.php');
        exit;
    }
} else {
    echo "ID is not available";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h5>Delete Confirmation</h5>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Are You Sure You Want To Delete This Item?</p>
                <form method="POST">
                    <div class="d-flex justify-content-center">
                        <button type="submit" name="yes" class="btn btn-danger mr-1">Yes</button>
                        <button type="submit" name="no" class="btn btn-secondary ml-1">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>