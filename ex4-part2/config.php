<?php
$host = 'sql8.freesqldatabase.com'; 
$dbname = 'sql8771852';         
$username = 'sql8771852';       
$password = 'PKNMCWk9Bc';     

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
