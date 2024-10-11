<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];

// Récupérer les informations du patient
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$first_name = htmlspecialchars($user['username']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - CareBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fb;
        }
        .welcome-section {
            background-color: #e3f2fd;
            padding: 60px 0;
        }
        .welcome-section h2 {
            font-size: 3rem;
            color: #007bff;
        }
        .welcome-image {
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
            color: #007bff; /* Couleur du livre bleu */
        }
        .action-buttons a {
            padding: 15px 30px;
            font-size: 1.2rem;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
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
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section de bienvenue -->
    <section class="welcome-section text-center">
        <div class="container">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="welcome-image" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5V19.5m-7.5-15h15v15h-15z" style="stroke:#007bff;"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 9H16.5M7.5 12H16.5" style="stroke:#007bff;"/>
            </svg>

            <h2 class="mb-3">Bienvenue, <?= $first_name ?> !</h2>
            <p class="lead">Nous sommes ravis de vous revoir. Consultez facilement votre carnet de vaccination et vos rendez-vous à venir.</p>
        </div>
    </section>

    <!-- Boutons d'action -->
    <div class="container text-center mt-5">
        <div class="row">
            <div class="col-md-4">
                <a href="vaccination_card.php" class="btn btn-success btn-lg">Voir mon carnet de vaccination</a>
            </div>
            <div class="col-md-4">
                <a href="request_appointment.php" class="btn btn-primary btn-lg">Prendre un nouveau rendez-vous</a>
            </div>
            <div class="col-md-4">
                <a href="informations_maladies.php" class="btn btn-info btn-lg">Informations sur les maladies et vaccins</a>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <footer class="mt-5 text-center">
        <p>&copy; 2024 CareBook - Votre santé, notre priorité.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
