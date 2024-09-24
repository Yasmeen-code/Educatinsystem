<?php
$errors = "";
try {
    $mycon = new PDO("mysql:host=localhost;dbname=stdsystem", "root", "");
    $mycon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $errors .= $e->getMessage();
}
