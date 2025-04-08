<?php
// Vérification de la présence de l'ID dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Identifiant invalide.";
    exit;
}

// Connexion PDO avec gestion d'erreurs
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

// Utilisation d'un prepared statement securise
$id = intval($_GET['id']);
$stmt = $db->prepare("SELECT * FROM student WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

// Gestion du cas où l'étudiant n'existe pas
if (!$etudiant) {
    echo "Étudiant non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail Étudiant</title>
    <style>
        body {
            background-color:rgb(188, 207, 255);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .card {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 25px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #007bff;
        }

        .breadcrumb {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.5;
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
    </style>
</head>
<body>
    <h2 style="text-align:center;">Détail Etudiant avec  prepared statements
    </h2>
    <div class="card">
        <div class="breadcrumb"><?= htmlspecialchars($etudiant['nom']) ?> &gt;</div>
        <p><strong>Nom :</strong> <?= htmlspecialchars($etudiant['nom']) ?></p>
        <p><strong>Date de naissance :</strong> <?= $etudiant['birthday'] ?></p>
    </div>
    <a href="ListeEtudiants.php">Retour a la page précédente</a><br>

</body>
</html>