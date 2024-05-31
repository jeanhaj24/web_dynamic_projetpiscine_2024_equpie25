<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$coach_id = $_POST['coach_id'];
$time_slot = $_POST['time_slot'];
$client_id = $_POST['client_id'];

// Insérer le rendez-vous dans la base de données
$query = "INSERT INTO RendezVous (client_id, coach_id, time_slot) VALUES ($client_id, $coach_id, '$time_slot')";
if (mysqli_query($db_handle, $query)) {
    echo "Rendez-vous enregistré avec succès.";
} else {
    echo "Erreur : " . mysqli_error($db_handle);
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
    <h2>Confirmation de Réservation</h2>
    <p>Votre réservation a été enregistrée avec succès.</p>
    <a href="main_acceuil.html">Retour à l'accueil</a>
</body>
</html>
