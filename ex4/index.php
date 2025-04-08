<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color:rgb(194, 205, 234);
        margin: 0;
        padding: 20px;
        text-align: center}

        a {
        display: inline-block;
        margin: 10px 0;
        padding: 10px 15px;
        text-decoration: none;
        color: #fff;
        background-color:rgb(41, 143, 246);
        border-radius: 5px;
        transition: background-color 0.3s ease;
        }

        a:hover {
        background-color:rgb(41, 143, 246);
        }

        script {
        display: none; /* Hides the script tag */
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur la page d'accueil</h1>
    <a href="insertion.php">Insertion d'un étudiant</a><br>
    <a href="affichage.php">Affichage de la liste des étudiants
    </a><br>
    <!-- test d'inscription resussite -->
    <?php
    if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo "<script>alert('Inscription réussie');</script>";
    }
    ?>
    <a href="ListeEtudiants.php">Affichage de la liste des étudiants avec details
    </a><br>
</body>
</html>