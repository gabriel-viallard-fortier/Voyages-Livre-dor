<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? esc($title) . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
    <?php if (isset($stylesheets)): ?>
        <?php foreach ($stylesheets as $style_path): ?>
            <link rel="stylesheet" href="<?php echo url($style_path); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="<?php echo url(); ?>" title="retour à l'accueil"><?php echo APP_NAME; ?></a>
            </div>
            
            <ul class="nav-menu">
                <li><a href="<?php echo url('home/index'); ?>">Accueil</a></li>
                <li class="menu text-white">
                    <button id="perContinent">
                        <a>Par continent</a>
                    </button><br>
                    <ul id="ulContinent" hidden>
                        <li id="Afrique">Afrique
                            <ul id="ulAfrique" hidden>
                                <li><a href="<?php echo url('destinations/ethiopie') ?>">Éthiopie</a></li>
                            </ul>
                        </li>
                        <li>Amérique</li>
                        <li id="Asie">Asie
                            <ul id="ulAsie" hidden>
                                <li><a href="<?php echo url('destinations/bali') ?>">Bali</a></li>
                                <li><a href="<?php echo url('destinations/cdn')?>">Corée du Nord</a></li>
                                <li><a href="<?php echo url('destinations/japon')?>">Japon</a></li>
                            </ul>
                        </li>
                        <li>Europe</li>
                        <li>Océanie</li>
                    </ul>
                </li>
                <li class="menu text-white">
                    <button id="perProfile">
                        <a>Par Guide</a>
                    </button><br>
                    <ul id="ulProfile" hidden>
                        <li><a href="<?php echo url('destinations/ethiopie') ?>">Gabriel</a></li>
                        <li><a href="<?php echo url('destinations/bali') ?>">Hichem</a></li>
                        <li><a href="<?php echo url('destinations/cdn') ?>">Johann</a></li>
                        <li><a href="<?php echo url('destinations/japon') ?>">Karim</a></li>
                    </ul>
                </li>

                <?php if (!isset($_SESSION['user']) || $_SESSION['user']['logged'] === false): ?>
                    <li><a href="<?php echo url('auth/register'); ?>">Inscription</a></li>
                    <li><a href="<?php echo url('auth/login'); ?>">Connection</a></li>
                <?php endif;
                if (isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] !== 0): ?>
                    <li><a href="<?php echo url('admin'); ?>">Admin panel</a></li>
                <?php endif; ?>
                <li><a href="<?php echo url('goldenbook/index'); ?>">Livre d'or</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['logged'] === true): ?>
                    <li><a href="<?php echo url('goldenbook/comment'); ?>">Commentaire</a></li>
                    <li><a href="<?php echo url('profile/index'); ?>">Profil</a></li>
                    <li><a href="<?php echo url('auth/deconnection'); ?>">Déconnection</a></li>
                <?php endif; ?>
                
            </ul>
        </nav>
    </header>

    </nav>
    </header>
    <main class="main-content">
        <?php flash_messages(); ?>
        <?php echo $content ?? ''; ?>
    </main>
<div class="p-2">

    <footer class="footer">
        <div class="footer-content">
            <li><a href="<?php echo url('home/about'); ?>">À propos</a></li>
            <li><a href="<?php echo url('home/contact'); ?>">Contact</a></li>
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Tous droits réservés.</p>
            <p>Version <?php echo APP_VERSION; ?></p>
        </div>
    </footer>
</div>
    
    <script src="<?php echo url('assets/js/app.js'); ?>"></script>
    <script src="<?php echo url('assets/js/script.js'); ?>"></script>
</body>

</html>