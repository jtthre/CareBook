<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];

// Récupérer les vaccins du patient
$stmt = $pdo->prepare("SELECT * FROM vaccines WHERE user_id = ?");
$stmt->execute([$user_id]);
$vaccines = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Vaccination - CareBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="text-center mb-4">Votre carnet de vaccination</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Vaccins Administrés</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php if (empty($vaccines)): ?>
    <li class="list-group-item">Aucun vaccin enregistré.</li>
<?php else: ?>
    <?php foreach ($vaccines as $vaccine): ?>
        <li class="list-group-item">
            Vaccin: <?= htmlspecialchars($vaccine['vaccine_name']) ?>, Date: <?= htmlspecialchars($vaccine['vaccination_date']) ?>
            <!-- Bouton Télécharger Certificat -->
            <form method="post" action="download_certificate.php" style="display:inline-block; float: right;">
                <input type="hidden" name="vaccine_id" value="<?= $vaccine['id'] ?>"> <!-- Assurez-vous que vous avez un champ ID dans la table des vaccins -->
                <button type="submit" class="btn btn-primary btn-sm">Télécharger Certificat</button>
            </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
