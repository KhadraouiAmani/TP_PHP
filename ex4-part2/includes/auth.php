<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est authentifié, c'est-à-dire si une session 'user' existe
if (!isset($_SESSION['user'])) {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header("Location: login.php");
    exit; // Arrête l'exécution du script pour ne pas continuer sur la page protégée
}
?>
