<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_demande = $_POST['date_demande'];
    $user_id = $_SESSION['user_id'];

    // Insérer la demande de rendez-vous dans la base de données
    $stmt = $pdo->prepare("INSERT INTO rendezvous (user_id, date_demande) VALUES (?, ?)");
    $stmt->execute([$user_id, $date_demande]);

    header("Location: tableau_de_bord.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un rendez-vous</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Prendre un rendez-vous</h2>
    <form method="post">
        <label for="date_demande">Choisir une date et une heure :</label>
        <input type="datetime-local" name="date_demande" required><br>
        <button type="submit">Demander un rendez-vous</button>
    </form>
</body>
</html>
