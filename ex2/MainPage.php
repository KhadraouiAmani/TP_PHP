<?php
require_once 'SessionManager.php';

$session = new SessionManager();
$session->start();

//session reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $session->destroy();
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}

//update visits
$visitCount = $session->get('visits');

//either first time
if ($visitCount === null) {
    $session->set('visits', 1);
    $message = "Bienvenue à notre plateforme.";

//or visit number n
} else {
    $visitCount++;
    $session->set('visits', $visitCount);
    $message = "Merci pour votre fidélité, c’est votre {$visitCount}ᵉ visite.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Session Test</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2><?php echo $message; ?></h2>

        <form method="POST">
            <button type="submit" name="reset">Réinitialiser la session</button>
        </form>
    </div>
</body>
</html>
