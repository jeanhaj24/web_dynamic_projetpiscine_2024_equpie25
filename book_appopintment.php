<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données de la requête AJAX
$coach_id = $_POST['coach_id'];
$time = $_POST['time'];

// Insérer le rendez-vous dans la base de données
$query = "INSERT INTO Appointments (coach_id, time) VALUES ($coach_id, '$time')";
if (mysqli_query($db_handle, $query)) {
    echo "Rendez-vous enregistré avec succès.";
} else {
    echo "Erreur : " . mysqli_error($db_handle);
}

// Fermez la connexion
mysqli_close($db_handle);
?>
