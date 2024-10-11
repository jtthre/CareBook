<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error_message = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Insérer le nouvel utilisateur dans la base de données
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, first_name, last_name, birth_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$username, $hashed_password, $first_name, $last_name, $birth_date]);

            $success_message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulaire d'inscription -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h2>Inscription</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($error_message) ?>
                            </div>
                        <?php elseif (isset($success_message)): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($success_message) ?>
                            </div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Prénom :</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Nom :</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Date de naissance :</label>
                                <input type="date" name="birth_date" id="birth_date" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur :</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe :</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Déjà inscrit ? <a href="index.php">Connectez-vous ici</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
