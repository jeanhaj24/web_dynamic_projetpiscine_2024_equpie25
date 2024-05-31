<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$type_compte = mysqli_real_escape_string($db_handle, $_POST['type_compte']);
$courriel = mysqli_real_escape_string($db_handle, $_POST['courriel']);
$password = mysqli_real_escape_string($db_handle, $_POST['password']);
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);

// Afficher les informations en fonction du type de compte
if ($type_compte == 'client') {
    $query = "SELECT * FROM Clients WHERE nom = '$nom' AND prenom = '$prenom' AND courriel = '$courriel' AND mot_de_passe = '$password'";
} elseif ($type_compte == 'coach') {
    $query = "SELECT * FROM Coachs WHERE nom = '$nom' AND prenom = '$prenom' AND courriel = '$courriel' AND password = '$password'";
} elseif ($type_compte == 'administrateur') {
    $query = "SELECT * FROM Administrateurs WHERE nom = '$nom' AND prenom = '$prenom' AND courriel = '$courriel' AND password = '$password'";
} else {
    die("Type de compte invalide.");
}

$result = mysqli_query($db_handle, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    foreach ($row as $key => $value) {
        if ($key == 'photo') {
            // Utiliser le chemin complet depuis la base de données
            $photo_path = htmlspecialchars($value);
            if (file_exists($photo_path)) {
                echo '<p>' . htmlspecialchars(ucfirst($key)) . ':</p>';
                echo '<img src="' . $photo_path . '" class="photo" alt="Photo de ' . htmlspecialchars($nom) . '">';
            } else {
                // Débogage : Afficher le chemin complet de la photo
                echo '<p>Photo non trouvée: ' . htmlspecialchars($photo_path) . '</p>';
                // Débogage : Afficher le chemin absolu pour plus de clarté
                echo '<p>Chemin absolu de la photo: ' . realpath($photo_path) . '</p>';
            }
        } else {
            echo '<p>' . htmlspecialchars(ucfirst($key)) . ': ' . htmlspecialchars($value) . '</p>';
        }
    }

    // Si c'est un coach, afficher toutes ses réservations
    if ($type_compte == 'coach') {
        $coach_id = $row['id'];
        $query_reservations = "SELECT Clients.nom AS client_nom, Clients.prenom AS client_prenom, RendezVous.time_slot 
                               FROM RendezVous 
                               JOIN Clients ON RendezVous.client_id = Clients.id 
                               WHERE RendezVous.coach_id = $coach_id";
        $result_reservations = mysqli_query($db_handle, $query_reservations);

        echo '<h2>Réservations:</h2>';
        if (mysqli_num_rows($result_reservations) > 0) {
            while ($reservation = mysqli_fetch_assoc($result_reservations)) {
                echo '<p>Client: ' . htmlspecialchars($reservation['client_prenom'] . ' ' . $reservation['client_nom']) . '<br>Time slot: ' . htmlspecialchars($reservation['time_slot']) . '</p>';
            }
        } else {
            echo '<p>Aucune réservation trouvée.</p>';
        }
    }

    // Si c'est un client, afficher toutes ses réservations avec la possibilité d'annuler
    if ($type_compte == 'client') {
        $client_id = $row['id'];
        $query_reservations = "SELECT Coachs.nom AS coach_nom, Coachs.prenom AS coach_prenom, RendezVous.time_slot, RendezVous.id AS appointment_id 
                               FROM RendezVous 
                               JOIN Coachs ON RendezVous.coach_id = Coachs.id 
                               WHERE RendezVous.client_id = $client_id";
        $result_reservations = mysqli_query($db_handle, $query_reservations);

        echo '<h2>Réservations:</h2>';
        if (mysqli_num_rows($result_reservations) > 0) {
            while ($reservation = mysqli_fetch_assoc($result_reservations)) {
                echo '<p>Coach: ' . htmlspecialchars($reservation['coach_prenom'] . ' ' . $reservation['coach_nom']) . '<br>Time slot: ' . htmlspecialchars($reservation['time_slot']) . '</p>';
                echo '<form method="post" action="cancel_appointment.php">
                        <input type="hidden" name="appointment_id" value="' . htmlspecialchars($reservation['appointment_id']) . '">
                        <button type="submit" class="btn btn-danger">Annuler</button>
                      </form>';
            }
        } else {
            echo '<p>Aucune réservation trouvée.</p>';
        }
    }

} else {
    echo '<p>Email ou mot de passe incorrect.</p>';
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
