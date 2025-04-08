<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Etudiants</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgb(188, 207, 255);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            color:rgba(8, 6, 106, 0.92);
            font-size: 2rem;
            margin-top: 40px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            padding: 30px;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin-bottom: 20px;
        }

        fieldset {
            border: none;
            padding: 0;
        }

        legend {
            font-size: 1.5em;
            font-weight: 600;
            color:rgb(26, 74, 122);
            margin-bottom: 10px;
            text-align: center;
        }

        table {
            margin: 0 auto; /* centre le tableau horizontalement */
            width: auto; /* laisse le tableau prendre juste la place nécessaire */
        }

        td {
            vertical-align: middle;
            padding: 10px;
        }

        td:first-child {
            width: 30%;
            font-weight: 500;
            color: black;
            text-align: center; 
            padding-right: 15px;
            font-weight: bold;
        }

        td:first-child {
            width: 30%;
            color: black;
            text-align: center; 
            padding-right: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"] {
            width: 250px; /* taille fixe et plus clean */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            border-color: #4a69bd;
            outline: none;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: rgb(41, 143, 246);
            color: #fff;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px 5px 0 0;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: rgb(41, 143, 246);
        }

        a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: rgb(41, 143, 246);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-bottom: 40px;
        }

        a:hover {
            background-color: rgb(41, 143, 246);
        }
        .button-container {
            display: flex;
            justify-content: center; 
            gap: 10px;
            padding-top: 10px;
            padding-left: 10px;
        }
    </style>
</head>

<body>
<h2>Liste des Etudiants</h2>

<?php

    //connexion a la base de donnees
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

    if (isset($_POST['Enregistrer'])){    //nom du bouton
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $birthday = $_POST['birthday'];
        if (!empty($id) && !empty($nom) && !empty($birthday)){
            //utilisation de requete preparee
            $requete = $db->prepare('INSERT INTO student(id,nom,birthday) VALUES (:id,:nom,:birthday)');
            $requete->bindvalue(':id',$id);
            $requete->bindvalue(':nom',$nom);
            $requete->bindvalue(':birthday',$birthday);
            //execution de la requete
            $result = $requete->execute();
            //test pour verifier l'execution de la requete
            if (!$result){
                echo "probleme d'execution de la requete";
            }
            else{
                echo "<script type=\"text/javascript\"> alert('Enregistrement effectué avec succés')";
            }
            header("Location: index.php?message=success");
            exit();
            //echo "<script type=\"text/javascript\"> window.location.href = 'insertion.php'; </script>";

        }
        else {
            echo "Probleme: Champ manquant!";
        }
    }  

?>


<form action="insertion.php" method="post">
    <fieldset>
        <legend><b>Formulaire</b></legend>
        <table >
            <tr> <!-- indique une ligne -->
                <td>Id:</td> <td><input type="text" name="id"></td>
            </tr>
            <tr>
                <td>Name:</td> <td><input type="text" name="nom"></td>
            </tr>
            <tr>
                <td>Birthday:</td> <td><input type="text" name="birthday"></td>
            </tr>
            <tr>
            <tr>
                <td colspan="2">
                    <div class="button-container">
                        <input type="reset" name="Effacer" value="Reset">
                        <input type="submit" name="Enregistrer" value="Submit">
                    </div>
                </td>
            </tr>

            </tr>
        </table>
    </fieldset>
</form>
<a href="index.php">Retour a la page initiale</a><br>

</body>
</html>