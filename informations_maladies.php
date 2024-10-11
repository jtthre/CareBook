<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maladies Actuelles et Vaccins - Carnet de Vaccination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CareBook</a>
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
                        <a class="nav-link" href="appointments.php">Mes Rendez-vous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diseases_info.php">Info sur des maladies</a>
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
        <h2 class="text-center mb-4">Maladies Actuelles et Vaccins</h2>

        <!-- Première maladie : Bronchiolite -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>1. Bronchiolite</h4>
            </div>
            <div class="card-body">
                <p><strong>Description :</strong> La bronchiolite est une infection respiratoire aiguë fréquente chez les nourrissons, surtout pendant la saison hivernale. Environ 30 % des enfants de moins de 2 ans sont touchés chaque année en France.</p>
                <p>Elle est causée principalement par le virus respiratoire syncytial (VRS) et se transmet par contact direct ou via des objets contaminés.</p>

                <p><strong>Mesures de protection :</strong></p>
                <ul>
                    <li><strong>Gestes barrières :</strong> Lavez-vous les mains, portez un masque si vous avez des symptômes, et limitez les sorties dans des lieux bondés avec votre enfant.</li>
                    <li><strong>Vaccination :</strong> Un vaccin (Abrysvo®) est disponible pour les femmes enceintes, ainsi qu'un traitement préventif pour les nourrissons (nirsévimab).</li>
                </ul>
                <p><strong>Précautions :</strong> Ces mesures sont essentielles pour limiter la propagation du virus et réduire les risques de complications.</p>
            </div>
        </div>

        <!-- Deuxième maladie : Leptospirose -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4>2. Leptospirose</h4>
            </div>
            <div class="card-body">
                <p><strong>Description :</strong> La leptospirose est une maladie bactérienne transmise par l'urine d'animaux infectés, notamment les rongeurs. Elle est rare en France mais présente, surtout dans les zones rurales et humides.</p>
                <p><strong>Symptômes :</strong> Forte fièvre, maux de tête, douleurs musculaires, avec des complications rénales ou hépatiques possibles.</p>

                <p><strong>Mesures de protection :</strong></p>
                <ul>
                    <li>Évitez les zones à risque (zones humides).</li>
                    <li>Portez des équipements de protection (gants, bottes).</li>
                    <li>Maintenez une bonne hygiène (laver soigneusement les fruits et légumes).</li>
                    <li><strong>Vaccination :</strong> Un vaccin est disponible pour certaines professions à risque.</li>
                </ul>
            </div>
        </div>

        <!-- Troisième maladie : Fièvre Q -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h4>3. Fièvre Q</h4>
            </div>
            <div class="card-body">
                <p><strong>Description :</strong> La fièvre Q est une maladie causée par la bactérie Coxiella burnetii, présente chez les animaux d'élevage (vaches, chèvres, moutons). Elle se transmet par inhalation de poussières contaminées.</p>
                <p><strong>Symptômes :</strong> Fièvre, maux de tête, et dans certains cas des infections cardiaques (endocardites).</p>

                <p><strong>Mesures de protection :</strong></p>
                <ul>
                    <li>Évitez les contacts directs avec les animaux malades, en particulier dans les fermes.</li>
                    <li>Portez des masques et des gants lors des manipulations à risque.</li>
                    <li>Désinfectez régulièrement les environnements de travail.</li>
                    <li><strong>Vaccination :</strong> Disponible pour les personnes à risque dans certains pays, mais pas encore en France.</li>
                </ul>
            </div>
        </div>

        <!-- Retour au tableau de bord -->
        <div class="text-center">
            <a href="dashboard.php" class="btn btn-primary">Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
