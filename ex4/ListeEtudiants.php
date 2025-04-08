<?php
$host = "sql7.freesqldatabase.com";
$dbname = "sql7771682";
$username = "sql7771682";
$password = "xLXUvGjaRB";
$port = "3306";
try {
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
$db = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
} catch (PDOException $e) {
die("Erreur de connexion : " . $e->getMessage());
}
$etudiants = $db->query("SELECT * FROM student")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(188, 207, 255);
            margin: 0;
            padding: 20px;
            color: #333;
            text-align: center;
        }

        h2 {
            color: #1565c0;
            font-size: 2em;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1565c0;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 0.95em;
        }

        a {
            display: block;
            width: fit-content;
            margin: 30px auto 0 auto;
            padding: 10px 20px;
            background-color: rgb(41, 143, 246);
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: rgb(41, 143, 246);
        }

        a, .details-icon {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .details-icon::before {
            content: 'ℹ️'; 
            font-size: 18px;
            cursor: pointer;
        }

        a, .return-button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        
    </style>
</head>
<body>

    <h2 style="text-align:center;">Liste des Étudiants</h2>
    <table>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>birthday</th>
            <th>détails</th>
        </tr>
        <?php foreach ($etudiants as $etudiant): ?>
        <tr>
            <td><?= $etudiant['id'] ?></td>
            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
            <td><?= $etudiant['birthday'] ?></td>
            <td>
                <!--detail Etudiant (page9) -->
                <!-- <a class="details-icon" href="detailEtudiant.php?id=<?= $etudiant['id'] ?>" title="Voir les détails">
                </a> -->
                <!--detail Etudiant avec prepared statements(page10) -->
                <a class="details-icon" href="detailEtudiantPrepStat.php?id=<?= $etudiant['id'] ?>" title="Voir les détails">
                </a> 
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a class="return-icon" href="index.php">Retour a la page initiale</a><br>
</body>
</html>