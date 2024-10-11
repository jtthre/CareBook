<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'docteur') {
    header("Location: index.php");
    exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = $_POST['appointment_id'];

    if (isset($_POST['valider'])) {
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'valide' WHERE id = ?");
        $stmt->execute([$appointment_id]);
    } elseif (isset($_POST['reprogrammer'])) {
        $new_date = $_POST['new_date'];
        if (!empty($new_date)) {
            $stmt = $pdo->prepare("UPDATE appointments SET status = 'reprogramme', new_date = ? WHERE id = ?");
            $stmt->execute([$new_date, $appointment_id]);
        }
    }
}

$stmt = $pdo->prepare("SELECT appointments.*, users.username AS patient_name 
                        FROM appointments 
                        JOIN users ON appointments.patient_id = users.id 
                        WHERE docteur_id = ? AND status = 'en_attente'");
$stmt->execute([$_SESSION['user_id']]);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les rendez-vous - Carnet de Vaccination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">CareBook</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_vaccine.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_appointments.php">Mes Rendez-vous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Inbox</a>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="logout.php" style="display:inline-block">
                            <button type="submit" class="btn btn-danger">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Gérer les rendez-vous</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Patient</th>
                    <th>Date du rendez-vous</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                        <td>
                            <!-- Valider -->
                            <form method="post" style="display:inline-block">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                <button type="submit" name="valider" class="btn btn-success">Valider</button>
                            </form>

                            <!-- Reprogrammer -->
                            <form method="post" style="display:inline-block">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                <input type="date" name="new_date" required class="form-control mb-2" style="display:inline-block; width:auto;">
                                <button type="submit" name="reprogrammer" class="btn btn-warning">Reprogrammer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
