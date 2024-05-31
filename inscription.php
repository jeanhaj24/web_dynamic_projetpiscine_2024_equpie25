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
$nom = mysqli_real_escape_string($db_handle, $_POST['nom']);
$prenom = mysqli_real_escape_string($db_handle, $_POST['prenom']);
$adresse_ligne1 = mysqli_real_escape_string($db_handle, $_POST['adresse_ligne_1']);
$adresse_ligne2 = mysqli_real_escape_string($db_handle, $_POST['adresse_ligne_2']);
$ville = mysqli_real_escape_string($db_handle, $_POST['ville']);
$code_postal = mysqli_real_escape_string($db_handle, $_POST['code_postal']);
$pays = mysqli_real_escape_string($db_handle, $_POST['pays']);
$telephone = mysqli_real_escape_string($db_handle, $_POST['telephone']);
$courriel = mysqli_real_escape_string($db_handle, $_POST['courriel']);
$carte_etudiant = mysqli_real_escape_string($db_handle, $_POST['carte_etudiant']);
$mot_de_passe = mysqli_real_escape_string($db_handle, $_POST['password']);

// Insérer les informations dans la table Clients
$query_client = "INSERT INTO Clients (nom, prenom, adresse_ligne1, adresse_ligne2, ville, code_postal, pays, telephone, courriel, carte_etudiant, mot_de_passe) 
                 VALUES ('$nom', '$prenom', '$adresse_ligne1', '$adresse_ligne2', '$ville', '$code_postal', '$pays', '$telephone', '$courriel', '$carte_etudiant', '$mot_de_passe')";

if (mysqli_query($db_handle, $query_client)) {
    // Récupérer l'ID du client inséré
    $client_id = mysqli_insert_id($db_handle);

    // Récupérer les informations de paiement du formulaire
    $type_carte = mysqli_real_escape_string($db_handle, $_POST['type_carte']);
    $nom_carte = mysqli_real_escape_string($db_handle, $_POST['nom_carte']);
    $numero_carte = mysqli_real_escape_string($db_handle, $_POST['numero_carte']);
    $date_expiration = mysqli_real_escape_string($db_handle, $_POST['date_expiration']) . '-01'; // Ajouter un jour pour compléter le format YYYY-MM-DD
    $code_securite = mysqli_real_escape_string($db_handle, $_POST['code_securite']);

    // Insérer les informations de paiement dans la table InformationsPaiement
    $query_paiement = "INSERT INTO InformationsPaiement (client_id, type_carte, nom_carte, numero_carte, date_expiration, code_securite) 
                       VALUES ($client_id, '$type_carte', '$nom_carte', '$numero_carte', '$date_expiration', '$code_securite')";

    if (mysqli_query($db_handle, $query_paiement)) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur lors de l'insertion des informations de paiement: " . mysqli_error($db_handle);
    }
} else {
    echo "Erreur lors de l'insertion des informations du client: " . mysqli_error($db_handle);
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
