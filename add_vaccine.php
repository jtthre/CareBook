<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'docteur') {
    header("Location: index.php");
    exit();
}
include 'db.php';

// Récupérer la liste des patients
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'patient'");
$stmt->execute();
$patients = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $vaccine = $_POST['vaccine'];
    $date_vaccine = $_POST['date_vaccine'];

    // Ajouter le vaccin
    $stmt = $pdo->prepare("INSERT INTO vaccines (user_id, vaccine_name, next_dose_date) VALUES (?, ?, ?)");
    $stmt->execute([$patient_id, $vaccine, $date_vaccine]);

    // Vérifier si le docteur a soumis le prochain rendez-vous
    if (isset($_POST['next_appointment']) && !empty($_POST['next_appointment_date'])) {
        $next_appointment_date = $_POST['next_appointment_date'];
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, docteur_id, appointment_date, status) VALUES (?, ?, ?, 'A venir')");
        $stmt->execute([$patient_id, $_SESSION['user_id'], $next_appointment_date]);
        echo '<div class="alert alert-success">Vaccin ajouté et prochain rendez-vous programmé avec succès.</div>';
    } else {
        echo '<div class="alert alert-success">Vaccin ajouté avec succès.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Vaccin - Carnet de Vaccination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CareBook</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_appointments.php">Mes Rendez-vous</a>
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
        <h2 class="text-center mb-4">Ajouter un vaccin</h2>

        <form method="post" class="border p-4 rounded shadow-sm bg-light">
            <div class="mb-3">
                <label for="patient_id" class="form-label">Sélectionner le patient :</label>
                <select name="patient_id" id="patient_id" class="form-select" required>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient['id'] ?>"><?= htmlspecialchars($patient['username']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="vaccine" class="form-label">Nom du vaccin :</label>
                <input type="text" name="vaccine" id="vaccine" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date_vaccine" class="form-label">Date du vaccin :</label>
                <input type="date" name="date_vaccine" id="date_vaccine" class="form-control" required>
            </div>

            <!-- Nouveau champ pour la date du prochain rendez-vous -->
            <div class="mb-3">
                <label for="next_appointment_date" class="form-label">Prochain rendez-vous (facultatif) :</label>
                <input type="date" name="next_appointment_date" id="next_appointment_date" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" name="submit_vaccine" class="btn btn-primary">Ajouter le vaccin</button>
                <button type="submit" name="next_appointment" class="btn btn-success">Ajouter le vaccin et programmer un rendez-vous</button>
            </div>
        </form>
    </div>
</body>
</html>
