<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$query = mysqli_real_escape_string($db_handle, $_POST['query']);

// Rechercher dans les tables
$coach_query = "SELECT * FROM Coachs WHERE nom LIKE '%$query%' OR prenom LIKE '%$query%' OR specialite LIKE '%$query%'";
$coach_result = mysqli_query($db_handle, $coach_query);

$salle_query = "SELECT * FROM SalleDeSport WHERE nom LIKE '%$query%' OR description LIKE '%$query%' OR adresse LIKE '%$query%' OR services LIKE '%$query%'";
$salle_result = mysqli_query($db_handle, $salle_query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Recherche - Sportify</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .coach-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .list-group-item img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
        }
        .list-group-item {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Résultats de la Recherche - Sportify</h1>
        
        <?php if (mysqli_num_rows($coach_result) > 0): ?>
            <h2>Coachs</h2>
            <div class="list-group">
                <?php while ($row = mysqli_fetch_assoc($coach_result)): ?>
                    <div class="list-group-item">
                        <img src="<?= htmlspecialchars($row['photo']) ?>" alt="Photo de <?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?>" class="coach-photo">
                        <div>
                            <h3><?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?></h3>
                            <p>Spécialité: <?= htmlspecialchars($row['specialite']) ?></p>
                            <p>Email: <?= htmlspecialchars($row['courriel']) ?></p>
                            <p>Disponibilité: <?= htmlspecialchars($row['disponibilite']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($salle_result) > 0): ?>
            <h2>Salles de Sport</h2>
            <div class="list-group">
                <?php while ($row = mysqli_fetch_assoc($salle_result)): ?>
                    <div class="list-group-item">
                        <div>
                            <h3><?= htmlspecialchars($row['nom']) ?></h3>
                            <p>Description: <?= htmlspecialchars($row['description']) ?></p>
                            <p>Adresse: <?= htmlspecialchars($row['adresse']) ?></p>
                            <p>Téléphone: <?= htmlspecialchars($row['telephone']) ?></p>
                            <p>Email: <?= htmlspecialchars($row['courriel']) ?></p>
                            <p>Règles d'utilisation: <?= htmlspecialchars($row['regles_utilisation']) ?></p>
                            <p>Services: <?= htmlspecialchars($row['services']) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($coach_result) == 0 && mysqli_num_rows($salle_result) == 0): ?>
            <p class="text-center">Aucun résultat trouvé pour votre recherche.</p>
        <?php endif; ?>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Fermez la connexion
mysqli_close($db_handle);
?>
