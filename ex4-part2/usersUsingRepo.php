<?php
require_once 'config.php';
require_once 'includes/UserClassRepo.php';

session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}


$isAdmin = $_SESSION['user']['role'] === 'admin';


$userClass = new UserClassRepo($conn);

// get all users
$users = $userClass->getAll();

// to get the selected user
$userId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$students = [];


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <title>Gérer les users</title>
</head>
<body>
    <h2>Liste des users</h2>
    
    <a href="add_user.php">Ajouter un user</a><br>
    
    <a href="dashboard.php">Retour au tableau de bord</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <?php if ($isAdmin): ?>
                    <th>Actions</th>
                    
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <?php if ($isAdmin): ?>
                        <td>
                            <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet user ?');">Supprimer</a>

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
    
</body>
</html>