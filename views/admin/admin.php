<?php session_start();

include('users-pdo.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] === 0 || $_SESSION['user']['logged'] === false) {
    header('Location: index.php');
    exit();
} else {
    $user = User::logged($_SESSION['user']);
    $displayPanel = $user->admin();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRATION</title>
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
    <div class="contain">
            <?= $_SESSION['message'] ?>

        <h1>Utilsateurs en BDD</h1>
        <table>
            <thead>
                <tr>
                    <?php foreach ($displayPanel as $user):
                        foreach ($user as $key => $field): ?>
                            <th><?= $key ?></th>
                        <?php endforeach; ?>

                        <?php break;
                    endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($displayPanel as $user): ?>
                    <tr>
                        <?php foreach ($user as $value): ?>
                            <td><?= $value ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</body>

</html>