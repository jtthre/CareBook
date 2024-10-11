<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];

// Récupérer les rendez-vous du patient
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE patient_id = ?");
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rendez-vous - CareBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Vos rendez-vous</h2>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Rendez-vous</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php if (empty($appointments)): ?>
                        <li class="list-group-item">Aucun rendez-vous pris.</li>
                    <?php else: ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <li class="list-group-item">
                                Rendez-vous le : <?= htmlspecialchars($appointment['appointment_date']) ?> 
                                - Statut : <?= htmlspecialchars($appointment['status']) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
