<?php
// Connectez-vous à la base de données
$db_handle = mysqli_connect('localhost', 'root', 'root', 'Sportify', 8888);

// Vérifiez la connexion
if (!$db_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupérer l'ID du coach depuis l'URL
$coach_id = intval($_GET['id']);

// Récupérer les informations du coach et ses horaires depuis la base de données
$query = "SELECT * FROM Coachs WHERE id = $coach_id";
$result = mysqli_query($db_handle, $query);
$coach = mysqli_fetch_assoc($result);

// Fermez la connexion
mysqli_close($db_handle);

// Fonction pour vérifier la disponibilité
function isAvailable($day, $availability) {
    return strpos($availability, $day) !== false;
}

$availability = $coach['disponibilite'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=1.0">
    <title>Sportify - Coach <?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .coach-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        .coach-details {
            text-align: center;
        }
        .schedule table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .schedule th, .schedule td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .schedule button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="coach-details">
            <img src="<?= htmlspecialchars($coach['photo']) ?>" alt="Coach <?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?>" class="coach-photo">
            <h1><?= htmlspecialchars($coach['prenom'] . ' ' . $coach['nom']) ?></h1>
            <p>Coach, <?= htmlspecialchars($coach['specialite']) ?><br>Courriel: <?= htmlspecialchars($coach['courriel']) ?></p>
        </div>

        <div class="schedule">
            <h2>Horaires de disponibilité</h2>
            <table>
                <tr>
                    <th>Jour</th>
                    <th>AM</th>
                    <th>PM</th>
                </tr>
                <tr>
                    <td>Lundi</td>
                    <td><?php if (isAvailable('Lundi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Lundi AM">Réserver</button>'; ?></td>
                    <td><?php if (isAvailable('Lundi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Lundi PM">Réserver</button>'; ?></td>
                </tr>
                <tr>
                    <td>Mardi</td>
                    <td><?php if (isAvailable('Mardi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Mardi AM">Réserver</button>'; ?></td>
                    <td><?php if (isAvailable('Mardi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Mardi PM">Réserver</button>'; ?></td>
                </tr>
                <tr>
                    <td>Mercredi</td>
                    <td><?php if (isAvailable('Mercredi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Mercredi AM">Réserver</button>'; ?></td>
                    <td><?php if (isAvailable('Mercredi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Mercredi PM">Réserver</button>'; ?></td>
                </tr>
                <tr>
                    <td>Jeudi</td>
                    <td><?php if (isAvailable('Jeudi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Jeudi AM">Réserver</button>'; ?></td>
                    <td><?php if (isAvailable('Jeudi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Jeudi PM">Réserver</button>'; ?></td>
                </tr>
                <tr>
                    <td>Vendredi</td>
                    <td><?php if (isAvailable('Vendredi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Vendredi AM">Réserver</button>'; ?></td>
                    <td><?php if (isAvailable('Vendredi', $availability)) echo '<button class="slot-button" data-coach-id="' . $coach_id . '" data-time="Vendredi PM">Réserver</button>'; ?></td>
                </tr>
            </table>
        </div>

        <div id="modal" class="modal">
            <div class="modal-content">
                <h2>Confirmer le rendez-vous</h2>
                <p id="modal-text"></p>
                <form id="booking-form" action="reserve.php" method="POST">
                    <label for="client-id">Entrez votre ID client :</label>
                    <input type="text" id="client-id" name="client_id" required>
                    <input type="hidden" id="coach-id" name="coach_id" value="<?= $coach_id ?>">
                    <input type="hidden" id="time-slot" name="time_slot">
                    <button type="submit" class="yes">Oui</button>
                    <button type="button" class="no">Non</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".slot-button").click(function () {
                var coachId = $(this).data("coach-id");
                var time = $(this).data("time");
                $("#modal-text").text("Voulez-vous vraiment prendre un rendez-vous pour " + time + " ?");
                $("#coach-id").val(coachId);
                $("#time-slot").val(time);
                $("#modal").show();
            });

            $(".no").off().click(function () {
                $("#modal").hide();
            });
        });
    </script>
</body>
</html>
