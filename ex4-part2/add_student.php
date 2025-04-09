<?php
require_once 'config.php'; 
require_once 'includes/Student.php';  

require_once 'includes/auth.php';  

$message = "";

$query = "SELECT * FROM sections";
$sections = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $image = $_POST['image'];  
    $section_id = $_POST['section_id'];  

    $studentObj = new Student($conn);

    $studentObj->create($name, $birthday, $image, $section_id);

    $message = "Étudiant ajouté avec succès !";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 20px;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

p {
    text-align: center;
    color: green;
    font-weight: bold;
    margin-top: 15px;
}
a {
    display: inline-block;
    margin: 10px 0;
    padding: 10px 15px;
    background-color:#007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

a:hover {
    background-color:  #0056b3;
}
    </style>
</head>
<body>
    <h2>Ajouter un étudiant</h2>

    <form method="POST" action="add_student.php">
        <label>Nom :</label>
        <input type="text" name="name" required><br>

        <label>Date de naissance :</label>
        <input type="date" name="birthday" required><br>

        <label>Image :</label>
        <input type="text" name="image" required><br> 

        <label>Section :</label>
        <select name="section_id" required>
            <option value="">Sélectionner une section</option>
            <?php foreach ($sections as $section): ?>
                <option value="<?= $section['id'] ?>"><?= $section['designation'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Ajouter</button>
    </form>

    <a href="students.php">Retour à la page précédente</a>
    <p><?= $message ?></p>
</body>
</html>
