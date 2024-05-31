<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nom_client = mysqli_real_escape_string($db_handle, $_POST['nom_client']);
$prenom_client = mysqli_real_escape_string($db_handle, $_POST['prenom_client']);
$ID_SalleDeSport = (int)$_POST['ID_SalleDeSport'];
$date = mysqli_real_escape_string($db_handle, $_POST['date']);
$heure = mysqli_real_escape_string($db_handle, $_POST['heure']);

// Insérer les informations dans la table VisiteSalle
$query = "INSERT INTO VisiteSalle (nom_client, prenom_client, ID_SalleDeSport, Date, heure) VALUES ('$nom_client', '$prenom_client', $ID_SalleDeSport, '$date', '$heure')";

if (mysqli_query($db_handle, $query)) {
    echo "Rendez-vous pris avec succès.";
} else {
    echo "Erreur: " . mysqli_error($db_handle);
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