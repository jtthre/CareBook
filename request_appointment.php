<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Récupérer la liste des docteurs pour que le patient puisse choisir
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'docteur'");
$stmt->execute();
$doctors = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $docteur_id = $_POST['docteur_id'];
    $appointment_date = $_POST['appointment_date'];
    
    // Insérer le rendez-vous dans la base de données
    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, docteur_id, appointment_date, status) VALUES (?, ?, ?, 'en_attente')");
    $stmt->execute([$_SESSION['user_id'], $docteur_id, $appointment_date]);
    
    // Message de succès après la prise de rendez-vous
    echo '<div class="alert alert-success">Rendez-vous demandé avec succès. En attente de validation par le docteur.</div>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander un Rendez-vous - Carnet de Vaccination</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
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
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vaccination_card.php">Mon carnet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_appointments.php">Mes Rendez-vous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="info_diseases.php">Info sur des maladies</a>
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
        <h2 class="text-center mb-4">Demander un Rendez-vous</h2>

        <form method="post" class="border p-4 rounded shadow-sm bg-light">
            <!-- Sélection du docteur -->
            <div class="mb-3">
                <label for="docteur_id" class="form-label">Sélectionner un docteur :</label>
                <select name="docteur_id" id="docteur_id" class="form-select" required>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date du rendez-vous -->
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Date du rendez-vous :</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Demander le rendez-vous</button>
        </form>

        <!-- Afficher les rendez-vous déjà demandés -->
        <div class="mt-5">
            <h3>Vos rendez-vous en attente</h3>
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Docteur</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupérer les rendez-vous du patient
                    $stmt = $pdo->prepare("SELECT appointments.*, users.username AS docteur_name 
                                            FROM appointments 
                                            JOIN users ON appointments.docteur_id = users.id 
                                            WHERE patient_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    $appointments = $stmt->fetchAll();
                    
                    foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['docteur_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($appointment['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
