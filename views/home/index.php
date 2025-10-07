<?php

$_SESSION['message'] = '';

// On vérifie si un utilisateur est connecté
if (isset($_SESSION['user']) && $_SESSION['user']['logged']) {
    $user = User::logged($_SESSION['user']);
}

// sinon, on crée une nouvelle instance
else {
    $user = new User();
} ?>
    <?= $_SESSION['message'] ?>


    <main>
        <h1 class="p-10">“Un voyage est la seule chose qui s'achète et vous rend plus riche.”</h1>
    </main>
