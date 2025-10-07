

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./css/voyages.css">
</head>
<body>
    <header>
        <h1>Voyages / Livre d'or</h1>
        <nav>
            <ul>
                <li><a href="./index.php">Accueil</a></li>
                <?php if (!isset($_SESSION['user']) || $_SESSION['user']['logged'] === false): ?>
                    <li><a href="./inscription.php">Inscription</a></li>
                    <li><a href="connection.php">Connection</a></li>
                <?php endif;
                if (isset($_SESSION['user']) && $_SESSION['user']['logged'] === true): ?>
                    <li><a href="./profile.php">Profil</a></li>
                    <li><a href="./deconnection.php">Déconnection</a></li>
                <?php endif;
                if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] !== 0): ?>
                    <li><a href="./admin.php">Admin panel</a></li>
                <?php endif; ?>
                <li><a href="./livre-or.php">Livre d'or</a></li>
                <li><a href="./commentaire.php">Commentaires</a></li>
            </ul>
        </nav>
    </header>



</body>

</html>