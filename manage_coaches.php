<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=1.0">
    <title>Gérer les Coachs - Sportify</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Gérer les Coachs - Sportify</h1>
        <div class="info-section">
            <h2>Ajouter un Coach</h2>
            <form id="addCoachForm" method="POST" action="add_coach.php">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="specialite">Spécialité :</label>
                    <input type="text" id="specialite" name="specialite" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="photo">Photo :</label>
                    <input type="text" id="photo" name="photo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cv">CV :</label>
                    <input type="text" id="cv" name="cv" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="courriel">Email :</label>
                    <input type="email" id="courriel" name="courriel" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="disponibilite">Disponibilité :</label>
                    <input type="text" id="disponibilite" name="disponibilite" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de Passe :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Ajouter le Coach</button>
            </form>
        </div>
        <div class="info-section mt-5">
            <h2>Supprimer un Coach</h2>
            <form id="deleteCoachForm" method="POST" action="delete_coach.php">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-danger btn-block">Supprimer le Coach</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
