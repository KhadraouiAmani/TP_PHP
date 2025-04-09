<?php
require_once 'config.php';
require_once 'includes/Student.php';

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}



$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;



$isAdmin = $_SESSION['user']['role'] === 'admin';


$studentClass = new Student($conn);


$students = $studentClass->getAllWithPagination($limit, $offset);


$totalStudents = $studentClass->getTotalStudents();
$totalPages = ceil($totalStudents / $limit);

//chercher par nom 
$searchTerm = $_GET['search'] ?? null;

if ($searchTerm) {
    $students = $studentClass->searchByName($searchTerm);
} else {
    $students = $studentClass->getAll();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <title>Gérer les étudiants</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    color: #333;
}

h2 {
    text-align: center;
    color: #007bff;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color:rgb(138, 135, 246);
    color: #fff;
    font-weight: bold;
}

td img {
    max-width: 50px;
    max-height: 50px;
    border-radius: 4px;
}

tr:hover {
    background-color: #f1f1f1;
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

.pagination {
    text-align: center;
    margin: 20px 0;
}

.pagination a {
    display: inline-block;
    margin: 0 5px;
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.pagination a:hover {
    background-color: #0056b3;
}

.pagination span {
    display: inline-block;
    margin: 0 5px;
    padding: 8px 12px;
    background-color: #ddd;
    color: #333;
    border-radius: 4px;
}

.admin-actions a {
    margin-right: 10px;
    color: #dc3545;
}

.admin-actions a:hover {
    color: #a71d2a;
}

button, .add-student, .back-dashboard {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover, .add-student:hover, .back-dashboard:hover {
    background-color: #0056b3;
}

.add-student {
    margin-bottom: 20px;
}

.back-dashboard {
    background-color: #6c757d;
}

.back-dashboard:hover {
    background-color: #5a6268;
}
    </style>
</head>
<body>
    <h2>Liste des étudiants</h2>


    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Image</th>
                <th>Section</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['id']) ?></td> 
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['birthday']) ?></td>
                    <td><img src="<?= htmlspecialchars($student['image']) ?>" alt="Image" width="50"></td>
                    <td><?= htmlspecialchars($student['designation']) ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="edit_student.php?id=<?= $student['id'] ?>">Modifier</a> |
                            <a href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">Supprimer</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!$isAdmin): ?>
        <p>En tant qu'utilisateur, vous ne pouvez pas modifier les informations.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <div>
        <?php if ($page > 1): ?>
            <a href="students.php?page=<?= $page - 1 ?>">Précédent</a>
        <?php endif; ?>

        Page <?= $page ?> sur <?= $totalPages ?>

        <?php if ($page < $totalPages): ?>
            <a href="students.php?page=<?= $page + 1 ?>">Suivant</a>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <a href="add_student.php">Ajouter un étudiant</a><br>
    <?php endif; ?>
    <a href="dashboard.php">Retour au tableau de bord</a>
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
