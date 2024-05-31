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
$specialite = mysqli_real_escape_string($db_handle, $_POST['specialite']);
$photo = mysqli_real_escape_string($db_handle, $_POST['photo']);
$cv = mysqli_real_escape_string($db_handle, $_POST['cv']);
$courriel = mysqli_real_escape_string($db_handle, $_POST['courriel']);
$disponibilite = mysqli_real_escape_string($db_handle, $_POST['disponibilite']);
$password = mysqli_real_escape_string($db_handle, $_POST['password']);

// Insérer les informations dans la table Coachs
$query = "INSERT INTO Coachs (nom, prenom, specialite, photo, cv, courriel, disponibilite, password) 
          VALUES ('$nom', '$prenom', '$specialite', '$photo', '$cv', '$courriel', '$disponibilite', '$password')";

if (mysqli_query($db_handle, $query)) {
    echo "Le coach a été ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout du coach: " . mysqli_error($db_handle);
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