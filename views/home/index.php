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

<div class="p-2">
    <main style="background-image: url('<?= BASE_URL . "/assets/images/bali/porte-temple-hindou-bali.webp"?>');">
        <h1 class="text-white p-10">“Un voyage est la seule chose qui s'achète et vous rend plus riche.”</h1>
    </main>
</div>