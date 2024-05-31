<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin.html");
    exit;
}

// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);

// Supprimer le coach de la table Coachs
$query = "DELETE FROM Coachs WHERE nom = '$nom' AND prenom = '$prenom'";

if (mysqli_query($db_handle, $query)) {
    echo "Le coach a été supprimé avec succès.";
} else {
    echo "Erreur lors de la suppression du coach: " . mysqli_error($db_handle);
}

// Fermez la connexion
mysqli_close($db_handle);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Confirmation</title>
</head>
<body>
    
    <a href="main_acceuil.html">Retour à l'accueil</a>
</body>
</html>