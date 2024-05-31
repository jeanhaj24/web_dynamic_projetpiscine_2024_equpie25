<?php
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

function sendMessage($db_handle) {
    $message = mysqli_real_escape_string($db_handle, $_POST['message']);
    $coach_id = (int)$_POST['coach_id'];
    $client_id = (int)$_POST['client_id'];
    $type = 'Texto';
    $date = date('Y-m-d');
    $heure = date('H:i:s');

    $query = "INSERT INTO Communications (type, message, date, heure, coach_id, client_id) VALUES ('$type', '$message', '$date', '$heure', $coach_id, $client_id)";
    if (mysqli_query($db_handle, $query)) {
        echo '<p>Message envoyé avec succès.</p>';
    } else {
        echo '<p>Erreur lors de l\'envoi du message: ' . mysqli_error($db_handle) . '</p>';
    }
}

function displayMessages($db_handle, $client_id, $coach_id) {
    $query = "SELECT * FROM Communications WHERE client_id = $client_id AND coach_id = $coach_id ORDER BY date ASC, heure ASC";
    $result = mysqli_query($db_handle, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="message-item">';
            echo '<strong>' . htmlspecialchars($row['type']) . ':</strong> ';
            echo '<p>' . htmlspecialchars($row['message']) . '</p>';
            echo '<small>' . htmlspecialchars($row['date']) . ' ' . htmlspecialchars($row['heure']) . '</small>';
            echo '</div>';
        }
    } else {
        echo '<p>Aucun message trouvé entre ce client et ce coach.</p>';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'send_message') {
    sendMessage($db_handle);
    $client_id = (int)$_POST['client_id'];
    $coach_id = (int)$_POST['coach_id'];
    displayMessages($db_handle, $client_id, $coach_id);
} elseif (isset($_GET['client_id']) && isset($_GET['coach_id'])) {
    $client_id = (int)$_GET['client_id'];
    $coach_id = (int)$_GET['coach_id'];
    displayMessages($db_handle, $client_id, $coach_id);
}




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
    <h2>Confirmation de envoie de message</h2>
    <p>Votre message a été envoyer avec succès.</p>
    <a href="acceuil_rdv.php">Retour à l'accueil</a>
</body>
</html>

