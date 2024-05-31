<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Requête pour obtenir les coachs
$query = "SELECT id, prenom, nom, specialite, photo, courriel FROM Coachs";
$result = mysqli_query($db_handle, $query);

// Fermez la connexion
mysqli_close($db_handle);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Accueil</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header {
            background: rgba(153, 85, 255, 0.8);
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        header img {
            height: 50px;
        }
        nav {
            align-items: center;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .hero {
            position: relative;
            color: white;
            text-align: center;
            height: 100vh;
            overflow: hidden;
        }
        .hero video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
            z-index: -1;
        }
        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 0;
        }
        .hero-content {
            position: relative;
            z-index: 1;
            padding: 50px;
        }
        .hero h1 {
            font-size: 3em;
        }
        .hero p {
            font-size: 1.5em;
        }
        .coaches {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
        }
        .coaches img {
            width: 100px;
            margin-bottom: 10px;
        }
        .coaches h2, .coaches h3, .coaches p {
            color: #333;
        }
        .coaches .coach {
            margin-bottom: 20px;
        }
        .coaches button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        footer {
            background-color: #f1f1f1;
            padding: 20px 0;
            text-align: center;
            position: relative;
            margin-top: 20px;
        }
        footer a {
            color: #004AAD;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <img src="Image/logo.png" alt="Sportify Logo">
            <a href="main_acceuil.html">Accueil</a>
            <a href="#">Tout Parcourir</a>
            <a href="#">Recherche</a>
            <a href="acceuil_rdv.php">Rendez-vous</a>
            <a href="compte.html">Votre Compte</a>
        </nav>
    </header>

    <section class="hero">
        <img src="rdv.jpeg" alt="Image de RDV">
        <div class="hero-content">
            <h1>Bienvenue sur Sportify</h1>
            <p>Votre application de sport personnalisée</p>
        </div>
    </section>

    <section class="coaches">
        <h2>Nos Coachs</h2>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="coach">
            <img src="<?= htmlspecialchars($row['photo']) ?>" alt="Coach <?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?>">
            <h3><?= htmlspecialchars($row['prenom'] . ' ' . $row['nom']) ?></h3>
            <p>ID: <?= htmlspecialchars($row['id']) ?><br>Coach, <?= htmlspecialchars($row['specialite']) ?><br>Email: <?= htmlspecialchars($row['courriel']) ?></p>
            <a href="coach.php?id=<?= htmlspecialchars($row['id']) ?>"><button class="view-coach">Voir les détails</button></a>
            <a href="messagerie.html"><button class="view-coach">Envoyer un message</button></a>
        </div>
        <?php endwhile; ?>
    </section>

    <footer>
        <p><a href="#">Mentions légales</a> | <a href="#">Politique de confidentialité</a> | <a href="#">Conditions d'utilisation</a></p>
        <p>© 2024 Sportify. Tous droits réservés.</p>
    </footer>
</body>
</html>
