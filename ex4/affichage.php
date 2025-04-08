<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(188, 207, 255);
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color:rgb(0, 0, 0);
        }

        table {
            width: 80%;
            margin: 0 auto 30px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color:rgb(124, 131, 240);
            color: white;
        }

        td:first-child {
            width: 30%;
            font-weight: bold;
            color: black;
        }

        a {
            display: block;
            width: fit-content;
            margin: 0 auto;
            padding: 10px 15px;
            background-color: rgb(41, 143, 246);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background-color: rgb(41, 143, 246);
        }
    </style>
</head>
<body>
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

//recuperation des donnees
$requete = "SELECT * FROM student ORDER BY id ASC";
//execution du resultat
$result = $db->query($requete);
//test
if (!$result){
    echo "échec dans la récupération des données";
}
else{
    echo "récupération des données éffectuée avec succes";
}
?>
<h2>Affichage de la liste des étudiants</h2>
<table>
    <tr> 
        <th>Id</th>  <!-- entete -->
        <th>Nom</th>
        <th>Birthday</th>
    </tr>
    <?php
    while ($ligne = $result->fetch(PDO::FETCH_NUM)){ //recuperation ligne par ligne
        echo "<tr>";//balise
        foreach ($ligne as $valeur){ //parcour du tableau
            echo "<td>$valeur</td>";
        }
        echo "</tr>";
    }
    ?>

</table>
<!-- liberer la connexion du serveur pour permettre a d'autre requete sql a etre executée sans probleme-->
<?php
    $result->closeCursor();
?>


<a href="index.php">Retour a la page initiale</a><br>
</body>
</html>