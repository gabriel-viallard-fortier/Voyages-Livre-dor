<?php
// Contrôleur d'authentification

/**
 * Page de connexion
 */
function auth_login()
{
    $data = [
        'title' => 'Connexion',
        'stylesheets' => [
            'assets/css/voyages.css',
        ],
    ];

    // Rediriger si déjà connecté
    if (is_logged_in()) {
        $user = User::logged($_SESSION['user']);
        redirect('home');
    }

    // sinon, on crée une nouvelle instance
    else {
        $user = new User();

        if (is_post()) {
            if (isset($_POST["ok"])) {
                if (verify_csrf_token($_POST["csrf_token"])) {

                    // on connecte l'utilisateur via la methode de classe et on stocke ses informations dans la SESSION['user']
                    $connection = $user->connect($_POST["email"], $_POST['password']);
                    if ($connection) {
                        // Si utilisateur:admin on redirige vers la page admin
                        if ($connection['isAdmin'] !== 0) {
                            if ($connection['logged'] === true) {
                                $_SESSION['user'] = $connection;
                                set_flash('success', "Connection réussie !");
                                redirect('admin/index');
                            } else {
                                set_flash('error', "Login / Mot de passe incorrect !");
                            }
                        }
                        // Si utilisateur:lambda on redirige vers la page profile
                        else {
                            if ($connection['logged'] === true) {
                                $_SESSION['user'] = $connection;
                                set_flash('success', "Connection réussie !");
                                redirect('profile/index');
                            } else {
                                set_flash('error', "Login / Mot de passe incorrect !");
                            }
                        }
                    }
                }
            }
        }
    }
    load_view_with_layout('auth/login', $data);
}
/**
 * Page d'inscription
 */
function auth_register()
{

    // On vérifie si un utilisateur est connecté
    if (is_logged_in()) {
        $user = User::logged($_SESSION['user']);
        redirect('home');
    } else {
        // sinon, on crée une nouvelle instance
        $user = new User();
        if (is_post()) {
            if (verify_csrf_token($_POST["csrf_token"])) {

                // SI ON PRESSE ENTER / OK
                if (isset($_POST["ok"])) {
                    // VÉRIFICATION MDP ENTRÉ CORRECTEMENT
                    if ($_POST['password1'] === $_POST['password2']) {
                        // ENREGISTREMENT DE L'UTILISATEUR DANS LA BASE DE DONNÉES
                        if ($user->register(0, $_POST['login'], $_POST['email'], $_POST['country'], $_POST['zip'], $_POST['password1'])) {
                            set_flash('success', "Inscription réussie !");

                            // Redirection vers la page de connection
                            redirect('auth/login');
                        } else {
                            set_flash('error', "Erreur lors de l'inscription en base de données");
                        }
                    } else {
                        set_flash('error', "Les mots de passe ne correspondent pas");
                    }
                }
            }
        }
        $data = [
            'title' => 'Inscription',
            'stylesheets' => [
                'assets/css/voyages.css',
            ],
        ];
    }
    load_view_with_layout('auth/register', $data);
}


/**
 * Déconnexion
 */
function auth_deconnection()
{
    $data = [
        'title' => 'Accueil',
        'stylesheets' => [
            'assets/css/voyages.css',
        ],
    ];
    session_destroy();
    set_flash('success',message: 'Déconnection réussie');
    load_view_with_layout('home/index', $data);
}