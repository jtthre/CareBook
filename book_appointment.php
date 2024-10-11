<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_date = $_POST['appointment_date'];
    $docteur_id = $_POST['docteur_id'];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, docteur_id, appointment_date) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $docteur_id, $appointment_date]);

    header("Location: dashboard.php");
    exit();
}

// Récupérer la liste des docteurs
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'docteur'");
$stmt->execute();
$docteurs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un rendez-vous - Carnet de Vaccination</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Prendre un rendez-vous</h2>
    <form method="post">
        <label for="docteur">Choisir un docteur :</label>
        <select name="docteur_id" id="docteur">
            <?php foreach ($docteurs as $docteur): ?>
                <option value="<?= $docteur['id'] ?>"><?= htmlspecialchars($docteur['username']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="date" name="appointment_date" required><br>
        <button type="submit">Demander un rendez-vous</button>
    </form>
</body>
</html>
