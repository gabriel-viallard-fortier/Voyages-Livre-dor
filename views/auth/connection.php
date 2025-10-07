<?php session_start();

include("users-pdo.php");
$_SESSION['message']= '';

// On vérifie si un utilisateur est connecté
// Si oui, on le redirige vers la page profil
if (isset($_SESSION['user']) && $_SESSION['user']['logged']) {
    $user = User::logged($_SESSION['user']);
    redirect('home/index');
}

// sinon, on crée une nouvelle instance
else {
    $user = new User();
}

if (isset($_POST["ok"])) {

    // on connecte l'utilisateur via la methode de classe et on stocke ses informations dans la SESSION['user']
    $connection = $user->connect($_POST["email"], $_POST['password']);

    // Si utilisateur:admin on redirige vers la page admin
    if ($connection['isAdmin'] !== 0) {
        if ($connection['logged'] === true) {
            $_SESSION['user'] = $connection;
            redirect('admin/index');
        }
        else {
            $_SESSION['message'] = "Login / Mot de passe incorrect !<br>";
        }
    }
    // Si utilisateur:lambda on redirige vers la page profile
    else {
        if ($connection['logged'] === true) {
            $_SESSION['user'] = $connection;
            redirect('profile/index');
        }
        else {
            $_SESSION['message'] = "Login / Mot de passe incorrect !<br>";
        }
    }
}
?>


    <?= $_SESSION['message'] ?>

        <div class="forms">
            <form id="Connection" name="LoginForm" onsubmit="return validateSignIn()" method="post">
                <fieldset>
                    <legend>CONNECTION</legend>
                    <label for="email ">Email :</label>
                    <input tabindex="1" class="margin-2" type="email" name="email" id="email">
                    <label for="password">Mot de passe :</label>
                    <input tabindex="1" type="password" class="margin-2" name="password" id="passsword">
                    <button type="submit" name="ok">Envoyer</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>