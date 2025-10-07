<?php
// Contrôleur d'authentification

/**
 * Page de connexion
 */
function auth_login()
{
    $_SESSION['message'] = '';
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
                // on connecte l'utilisateur via la methode de classe et on stocke ses informations dans la SESSION['user']
                $connection = $user->connect($_POST["email"], $_POST['password']);
                if ($connection) {
                    // Si utilisateur:admin on redirige vers la page admin
                if ($connection['isAdmin'] !== 0) {
                    if ($connection['logged'] === true) {
                            $_SESSION['user'] = $connection;
                        redirect('admin/index');
                    } else {
                        $_SESSION['message'] = "Login / Mot de passe incorrect !<br>";
                    }
                }
                // Si utilisateur:lambda on redirige vers la page profile
                else {
                    if ($connection['logged'] === true) {
                        $_SESSION['user'] = $connection;
                        redirect('profile/index');
                    } else {
                        $_SESSION['message'] = "Login / Mot de passe incorrect !<br>";
                    }
                }
                }
            }
        }
    }
    load_view_with_layout('auth/login', $data);
}
// $email = clean_input(post('email'));
// $password = post('password');

// if (empty($email) || empty($password)) {
//     set_flash('error', 'Email et mot de passe obligatoires.');
// } else {
//     // Rechercher l'utilisateur
//     $user = get_user_by_email($email);

//     if ($user && verify_password($password, $user['password'])) {
//         // Connexion réussie
//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['user_name'] = $user['name'];
//         $_SESSION['user_email'] = $user['email'];
//         $_SESSION['admin'] = $user['admin'];

//         set_flash('success', 'Connexion réussie !');
//         redirect('home');
//     } else {
//         set_flash('error', 'Email ou mot de passe incorrect.');
//     }
// }











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
            // SI ON PRESSE ENTER / OK
            if (isset($_POST["ok"])) {
                // VÉRIFICATION MDP ENTRÉ CORRECTEMENT
                if ($_POST['password1'] === $_POST['password2']) {
                    // ENREGISTREMENT DE L'UTILISATEUR DANS LA BASE DE DONNÉES
                    if ($user->register(0, $_POST['login'], $_POST['email'], $_POST['country'], $_POST['zip'], $_POST['password1'])) {
                        // Redirection vers la page de connection
                        redirect('auth/login');
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
//         $name = clean_input(post('name'));
//         $email = clean_input(post('email'));
//         $password = post('password');
//         $confirm_password = post('confirm_password');

//         // Validation
//         if (empty($name) || empty($email) || empty($password)) {
//             set_flash('error', 'Tous les champs sont obligatoires.');
//         } elseif (!validate_email($email)) {
//             set_flash('error', 'Adresse email invalide.');
//         } elseif (!validate_password($password)) {
//             set_flash('error', "Le mot de passe doit contenir au moins 8 caractères avec majuscules, minuscules
// et chiffres.");
//         } elseif ($password !== $confirm_password) {
//             set_flash('error', 'Les mots de passe ne correspondent pas.');
//         } elseif (get_user_by_email($email)) {
//             set_flash('error', "l'email est déjà utilisé par un autre compte.");
//         } else {
//             $name = ucwords($name, "- ");
//             // Créer l'utilisateur
//             $user_id = create_user($name, $email, $password);
//             if ($user_id) {
//                 set_flash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
//                 redirect('auth/login');
//             } else {
//                 set_flash('error', 'Une erreur est survenue. Veuillez réessayer.');
//             }
//         }


/**
 * Déconnexion
 */
function auth_logout()
{
    logout();
}