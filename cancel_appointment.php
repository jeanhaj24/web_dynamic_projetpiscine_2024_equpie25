<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer l'ID de la réservation à annuler
$appointment_id = intval($_POST['appointment_id']);

// Supprimer la réservation de la base de données
$query = "DELETE FROM RendezVous WHERE id = $appointment_id";
if (mysqli_query($db_handle, $query)) {
    echo '<p>Réservation annulée avec succès.</p>';
} else {
    echo '<p>Erreur lors de l\'annulation de la réservation: ' . mysqli_error($db_handle) . '</p>';
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
    <h2>Confirmation de Annulation</h2>
    <p>Votre réservation a été annuler avec succès.</p>
    <a href="main_acceuil.html">Retour à l'accueil</a>
</body>
</html>