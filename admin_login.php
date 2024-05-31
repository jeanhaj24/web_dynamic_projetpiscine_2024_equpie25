<?php
session_start();

// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$courriel = mysqli_real_escape_string($db_handle, $_POST['courriel']);
$password = mysqli_real_escape_string($db_handle, $_POST['password']);
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);

// Vérifier les informations de l'administrateur
$query = "SELECT * FROM Administrateurs WHERE courriel = '$courriel' AND password = '$password' AND nom = '$nom' AND prenom = '$prenom'";
$result = mysqli_query($db_handle, $query);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: manage_coaches.php");
} else {
    echo "Email ou mot de passe incorrect.";
}

// Fermez la connexion
mysqli_close($db_handle);
?>
