<?php
require_once 'config.php';
require_once 'includes/SectionClassRepo.php';

session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


$isAdmin = $_SESSION['user']['role'] === 'admin';


//we use the repo class
$sectionClass = new SectionClassRepo($conn);


$sections = $sectionClass->getAll();


$sectionId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$students = [];


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <title>Gérer les sections</title>
</head>
<body>
    <h2>Liste des sections</h2>
    <?php if ($isAdmin): ?>
        <a href="add_section.php">Ajouter une section</a><br>
    <?php endif; ?>
    <a href="dashboard.php">Retour au tableau de bord</a>

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
                            <a href="delete_section.php?id=<?= $section['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette section ?');">Supprimer</a>

                        </td>
                    <?php endif; ?>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
</body>
</html>

