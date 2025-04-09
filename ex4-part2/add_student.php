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

    <p><?= $message ?></p>
</body>
</html>
