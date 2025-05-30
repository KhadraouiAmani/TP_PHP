<?php
require_once 'config.php';
require_once 'includes/Section.php';

session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


$isAdmin = $_SESSION['user']['role'] === 'admin';


$sectionClass = new Section($conn);


$sections = $sectionClass->getAll();

$sectionId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$students = [];

if ($sectionId) {
    $students = $sectionClass->getStudentsBySection($sectionId);
    
 
    $sectionDetails = $sectionClass->getById($sectionId);
    $sectionName = $sectionDetails['designation'];  
        
    $searchTerm = $_GET['search'] ?? null;

    if ($searchTerm) {
        $sections = $sectionClass->searchByName($searchTerm);
    } else {
        $sections = $sectionClass->getAll();
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <title>Gérer les sections</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
}

h2, h3 {
    text-align: center;
    color: #007bff;
    margin-bottom: 20px;
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

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #fff;
    box-shadow: 0
}
th {
    background-color:rgb(138, 135, 246);
    color: #fff;
    font-weight: bold;
}
    </style>
</head>
<body>
    <h2>Liste des sections</h2>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Description</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                    
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sections as $section): ?>
                <tr>
                    <td><?= $section['id'] ?></td>
                    <td><?= htmlspecialchars($section['designation']) ?></td>
                    <td><?= !empty($section['description']) ? htmlspecialchars($section['description']) : '(vide)' ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="edit_section.php?id=<?= $section['id'] ?>">Modifier</a> |
                            <a href="delete_section.php?id=<?= $section['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette section ?');">Supprimer</a>
                            <a href="sections.php?id=<?= $section['id'] ?>">Voir les étudiants</a>
                        </td>
                    <?php endif; ?>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($sectionId): ?>
        <h3>Liste des étudiants dans la section <?= htmlspecialchars($sectionName) ?></h3>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student['id'] ?></td>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['birthday']) ?></td>
                            <td><img src="<?= htmlspecialchars($student['image']) ?>" alt="Image de <?= $student['name'] ?>" width="50" height="50"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun étudiant dans cette section.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $('table').DataTable();
        });
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('table').DataTable().destroy();
            $('table').DataTable({
                dom: 'Bfrtip', 
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ]
            });
        });

    </script>
    <?php if ($isAdmin): ?>
        <a href="add_section.php">Ajouter une section</a><br>
    <?php endif; ?>
    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>