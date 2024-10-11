<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'docteur') {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Obtenir tous les rendez-vous en attente
$stmt = $pdo->prepare("SELECT r.id, u.username, r.date_demande, r.statut, r.nouvelle_date FROM rendezvous r JOIN users u ON r.user_id = u.id WHERE r.statut = 'en_attente'");
$stmt->execute();
$rendezvous = $stmt->fetchAll();

// Gérer la validation ou la reprogrammation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rendezvous_id = $_POST['rendezvous_id'];
    $action = $_POST['action'];
    $nouvelle_date = $_POST['nouvelle_date'] ?? null;

    if ($action == 'approuver') {
        // Approuver le rendez-vous
        $stmt = $pdo->prepare("UPDATE rendezvous SET statut = 'approuvé' WHERE id = ?");
        $stmt->execute([$rendezvous_id]);
    } elseif ($action == 'reprogrammer') {
        // Reprogrammer le rendez-vous
        $stmt = $pdo->prepare("UPDATE rendezvous SET statut = 'reprogrammé', nouvelle_date = ? WHERE id = ?");
        $stmt->execute([$nouvelle_date, $rendezvous_id]);
    }

    header("Location: gerer_rendezvous.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les rendez-vous</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Gérer les rendez-vous</h2>
    <table border="1">
        <tr>
            <th>Patient</th>
            <th>Date demandée</th>
            <th>Action</th>
        </tr>
        <?php foreach ($rendezvous as $rdv): ?>
            <tr>
                <td><?= htmlspecialchars($rdv['username']) ?></td>
                <td><?= htmlspecialchars($rdv['date_demande']) ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="rendezvous_id" value="<?= $rdv['id'] ?>">
                        <button type="submit" name="action" value="approuver">Approuver</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="rendezvous_id" value="<?= $rdv['id'] ?>">
                        <input type="datetime-local" name="nouvelle_date" required>
                        <button type="submit" name="action" value="reprogrammer">Reprogrammer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
