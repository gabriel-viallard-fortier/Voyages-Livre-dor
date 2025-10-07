<?php

function admin_add_book()
{
    $book_data = [];

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add book without valid token");
            redirect('home/profile');
        }

        [$is_valid, $book_data] = book_validation();

        if ($is_valid) {
            insert_new_media($book_data, MediaType::Book);
            redirect('admin/medias');
        }
    }

    $data = [
        "entries" => $book_data,
        "action" => 'Ajouter',
        "genre_enum" => get_books_genres(),
    ];

    load_view_with_layout("admin/add_book", $data);
}
function admin_add_movie()
{
    $movie_data = [];

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add movie without valid token");
            redirect('home/profile');
        }

        [$is_valid, $movie_data] = movie_validation();

        if ($is_valid) {
            insert_new_media($movie_data, MediaType::Movie);
            redirect('admin/medias');
        }
    }

    $data = [
        "entries" => $movie_data,
        "action" => 'Ajouter',
        "genre_enum" => get_movies_genres(),
        "certification_enum" => get_movies_certifications(),
    ];

    load_view_with_layout("admin/add_movie", $data);
}

function admin_add_game()
{
    $game_data = [];

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to add game without valid token");
            redirect('home/profile');
        }

        [$is_valid, $game_data] = game_validation();

        if ($is_valid) {
            insert_new_media($game_data, MediaType::Game);
            redirect('admin/medias');
        }
    }

    $data = [
        "entries" => $game_data,
        "action" => 'Ajouter',
        "genre_enum" => get_games_genres(),
        "plateform_enum" => get_games_plateforms(),
        "pegi_enum" => get_games_pegis(),
    ];

    load_view_with_layout("admin/add_game", $data);
}
function admin_index()
{
    $data = [
        'title' => 'Admin Medias Dashboard',
        'stylesheets' => [
            'assets/css/admin.css',
            'assets/css/user.css'
        ],
        'list' => get_late_return_list()
    ];
    load_view_with_layout("admin/index", $data);
}

function admin_medias()
{
    $data = [
        'title' => 'Admin Medias Dashboard',
        'stylesheets' => [
            'assets/css/search-bar.css',
            'assets/css/pagination.css',
            'assets/css/confirm-popover.css',
            'assets/css/admin.css',
            'assets/css/user.css',
        ],
    ];
    $filter_list = ["title", "type", "genre", "available"];
    $filters = [];
    foreach ($filter_list as $filter) {
        if (isset($_GET[$filter])) {
            $clean_input = clean_input($_GET[$filter]);
            if (!empty($clean_input)) {
                $filters[$filter] = $clean_input;
            }
        }
    }
    $medias = get_medias($filters);
    $data = array_merge($data, $medias);

    load_view_with_layout('admin/medias', $data);
}

function admin_edit_book()
{
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }

    $id = (int) $_GET['id'];
    $book_data = get_book_by_id($id);

    if (!$book_data) {
        set_flash('error', "Média introuvable");
        redirect('admim/medias');
    }

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit book without valid token");
            redirect('home/profile');
        }

        [$is_valid, $inputs] = book_validation(true);

        foreach ($inputs as $field => $value) {
            $book_data[$field] = $value;
        }

        if ($is_valid) {
            update_media($book_data, MediaType::Book);
            redirect('admin/medias');
        }
    }
    $data = [
        "action" => 'Modifier',
        "entries" => $book_data,
        "genre_enum" => get_books_genres(),
    ];
    load_view_with_layout('admin/add_book', $data);
}

function admin_users()
{
    $data = [
        'stylesheets' => [
            'assets/css/pagination.css',
            'assets/css/user.css',
            'assets/css/confirm-popover.css'
        ]
    ];

    try {
        $data['current_page'] = get_current_page();
        $limit = 10;
        $data['pages'] = ceil(count_users() / $limit);
        $offset = ($data['current_page'] - 1) * $limit;
        $data['users'] = get_all_users($limit, $offset);
        $data['fields'] = ['Id', 'Nom', 'Email', 'Création', 'Emprunts en cours', 'Stats'];

        load_view_with_layout('admin/users', $data);
    } catch (Exception $e) {
        error_logging(ErrorType::Error, $e->getMessage());
        redirect('admin/users');
    }
}

function admin_edit_movie()
{
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }

    $id = (int) $_GET['id'];
    $movie_data = get_movie_by_id($id);

    if (!$movie_data) {
        set_flash('error', "Média introuvable");
        redirect('admin/medias');
    }

    // Validation du formulaire
    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit movie without valid token");
            redirect('home/profile');
        }
        // Validation des entrées du formulaire en accord avec le cahier des charges
        [$is_valid, $inputs] = movie_validation(true);
    
        foreach ($inputs as $field => $value) {
            $movie_data[$field] = $value;
        }
        // Mise a jour de la BDD
        if ($is_valid) {
            update_media($movie_data, MediaType::Movie);
            redirect('admin/medias');
        }
    }

    $data = [
        "action" => 'Modifier',
        "entries" => $movie_data,
        "genre_enum" => get_movies_genres(),
        "certification_enum" => get_movies_certifications(),

    ];
    load_view_with_layout('admin/add_movie', $data);
}

function admin_edit_game()
{
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }

    $id = (int) $_GET['id'];
    $game_data = get_game_by_id($id);

    if (!$game_data) {
        set_flash('error', "Média introuvable");
        redirect('admin/medias');
    }

    if (is_post()) {
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            set_flash('error', "Token CSRF invalide");
            error_logging(ErrorType::Error, "Tried to edit game without valid token");
            redirect('home/profile');
        }

        [$is_valid, $inputs] = game_validation(true);

        foreach ($inputs as $field => $value) {
            $game_data[$field] = $value;
        }

        if ($is_valid) {
            update_media($game_data, MediaType::Game);
            redirect('admin/medias');
        }
    }

    $data = [
        "action" => 'Modifier',
        "entries" => $game_data,
        "genre_enum" => get_games_genres(),
        "plateform_enum" => get_games_plateforms(),
        "pegi_enum" => get_games_pegis(),
    ];


    load_view_with_layout('admin/add_game', $data);
}


function admin_delete_media()
{

    // Validation de l'id
    if (!is_post() || !isset($_POST['id']) || !filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        set_flash('error', "ID média invalide");
        redirect('admin/medias');
    }

    $id = (int) $_POST['id'];
    $media = get_media_by_id($id);

    if (!$media) {
        set_flash('error', "Média inexistant");
        redirect('admin/medias');
    }

    // Verification si déjà emprunté par un utilisateur
    if (is_media_already_borrowed($id)) {
        set_flash("error", "Impossible de supprimer ce média car emprunt en cours");
        error_logging(ErrorType::Warning, "Tried to delete borrowed media: " . $id);
    } else {
        // On supprime l'image associée au média
        $cover_path = $media['cover_img'];
        if ($cover_path) {
            if (!unlink(UPLOAD_PATH . "/" . $cover_path)) {
                set_flash('error', "Erreur lors de la suppression de la jaquette");
                error_logging(ErrorType::Error, "Can't delete cover_img at " . $cover_path);
            }
        }
        // On supprime le média de la BDD
        delete_media($id);
        set_flash("success", "Média supprimé avec succes");
        error_logging(ErrorType::Info, "Successfull deleted media: " . $id);
    }
    redirect('admin/medias');
}

function admin_delete_user()
{
    if (is_post() && isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        $redirect_url = $_POST['redirect'] ?? '';
        if (!verify_csrf_token(post('csrf_token', ''))) {
            error_logging(ErrorType::Warning, 'Wrong csrf token');
            redirect($redirect_url);
        }
        try {
            $id = (int) $_POST['id'];
            if (delete_user($id)) {
                set_flash('success', 'Utilisateur supprimé');
                error_logging(ErrorType::Info, "User with id: $id deleted");
            } else {
                set_flash("error", "L'utilisateur a des emprunts");
                error_logging(ErrorType::Error, "Failed to delete user with id: $id");
            }
        } catch (Exception $e) {
            error_logging(ErrorType::Error, '' . $e->getMessage());
        }
    }
    redirect($redirect_url ?? '');
}

function admin_force_return()
{
    if (
        !is_post() || !isset($_POST['user_id']) || !isset($_POST['media_id']) ||
        !filter_var($_POST['user_id'], FILTER_VALIDATE_INT) ||
        !filter_var($_POST['media_id'], FILTER_VALIDATE_INT)
    ) {
        set_flash('error', 'Echec du retour');
        redirect("admin/users");
    }
    $redirect_url = $_POST['redirect'] ?? '';
    $media_id = (int) $_POST['media_id'];
    $user_id = (int) $_POST['user_id'];

    if (!return_media($media_id, $user_id)) {
        set_flash('error', "Une erreur est survenue. Veuillez réessayer.");
    } else {
        set_flash("success", "Le media a été rendu");
    }
    redirect($redirect_url);
}
