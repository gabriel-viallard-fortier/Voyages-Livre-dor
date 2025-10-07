<?php
// Fonctions utilitaires

/**
 * Sécurise l'affichage d'une chaîne de caractères (protection XSS)
 */
function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Affiche une chaîne sécurisée (échappée)
 */
function e($string)
{
    echo escape($string);
}

/**
 * Retourne une chaîne sécurisée sans l'afficher
 */
function esc($string)
{
    return escape($string);
}

/**
 * Génère une URL absolue
 */
function url($path = '')
{
    $base_url = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $base_url . '/' . $path;
}

/**
 * Redirection HTTP
 */
function redirect($path = '')
{
    $url = url($path);
    header("Location: $url");
    exit;
}

/**
 * Génère un token CSRF
 */
function csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie un token CSRF
 */
function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Définit un message flash
 */
function set_flash($type, $message)
{
    $_SESSION['flash_messages'][$type][] = $message;
}

/**
 * Récupère et supprime les messages flash
 */
function get_flash_messages($type = null)
{
    if (!isset($_SESSION['flash_messages'])) {
        return [];
    }

    if ($type) {
        $messages = $_SESSION['flash_messages'][$type] ?? [];
        unset($_SESSION['flash_messages'][$type]);
        return $messages;
    }

    $messages = $_SESSION['flash_messages'];
    unset($_SESSION['flash_messages']);
    return $messages;
}

/**
 * Vérifie s'il y a des messages flash
 */
function has_flash_messages($type = null)
{
    if (!isset($_SESSION['flash_messages'])) {
        return false;
    }

    if ($type) {
        return !empty($_SESSION['flash_messages'][$type]);
    }

    return !empty($_SESSION['flash_messages']);
}

/**
 * Nettoie une chaîne de caractères
 */
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Valide une adresse email
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Génère un mot de passe sécurisé
 */
function generate_password($length = 12)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

/**
 * Hache un mot de passe
 */
function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Vérifie un mot de passe
 */
function verify_password($password, $hash)
{
    return password_verify($password, $hash);
}

/**
 * Formate une date
 */
function format_date($date, $format = 'd/m/Y H:i')
{
    return date($format, strtotime($date));
}

/**
 * Vérifie si une requête est en POST
 */
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Vérifie si une requête est en GET
 */
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Retourne la valeur d'un paramètre POST
 */
function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

/**
 * Retourne la valeur d'un paramètre GET
 */
function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}

/**
 * Vérifie si un utilisateur est connecté
 */
function is_logged_in()
{
    return isset($_SESSION['user']['logged']);
}

/**
 * Retourne l'ID de l'utilisateur connecté
 */
function current_user_id()
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Déconnecte l'utilisateur
 */
function logout()
{
    session_destroy();
    redirect('auth/login');
}

/**
 * Formate un nombre
 */
function format_number($number, $decimals = 2)
{
    return number_format($number, $decimals, ',', ' ');
}

/**
 * Génère un slug à partir d'une chaîne
 */
function generate_slug($string)
{
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    return trim($string, '-');
}



/**
 *  custom functions starting from here
 */

enum ErrorType: string
{
    case Warning = "Warning";
    case Error = "Error";
    case Info = "Info";
    case Debug = "Debug";
}

function error_logging(ErrorType $type, string $message)
{
    $log_file = LOG_PATH . '/app.log';
    if (!file_exists($log_file)) {
        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH, 0755, true);
        }
        touch($log_file);
    }
    $date = date('Y-m-d H:i:s');
    error_log("[$date] [$type->value] $message\n", 3, $log_file);
}

function validate_upload($file): array
{
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => "Le fichier téléchargé dépasse la directive upload_max_filesize dans php.ini",
        UPLOAD_ERR_FORM_SIZE => "Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML",
        UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé",
        UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant",
        UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque",
        UPLOAD_ERR_EXTENSION => "Une extension PHP a interrompu le téléchargement du fichier",
    ];

    if ($file["error"] !== UPLOAD_ERR_OK) {
        throw new Exception($errorMessages[$file["error"]]);
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new Exception("Le fichier upload ne vient pas d'une requête POST");
    }
    if ($file["size"] > UPLOAD_MAX_SIZE) {
        throw new Exception("Erreur lors de l'upload de l'image. Vérifiez le format et la taille.");
    }

    // get the image infos
    $file_info = getimagesize($_FILES["cover_img"]["tmp_name"]);

    if ($file_info === false) {
        throw new Exception("Erreur lors de l'upload de l'image. Vérifiez le format et la taille.");
    }

    $width = $file_info[0];
    $height = $file_info[1];
    if ($width < 100 || $height < 100) {
        throw new Exception("Erreur lors de l'upload de l'image. Vérifiez le format et la taille.");
    }
    $file_extension = explode("/", $file["type"])[1];
    $file_mime_type = explode("/", $file_info["mime"])[1];
    $allowed_types = ["jpeg", "jpg", "png", "gif"];

    if (!in_array($file_extension, $allowed_types) || !in_array($file_mime_type, $allowed_types)) {
        throw new Exception("Type de fichier non valide (formats acceptés : jpg, png, gif).");
    }
    $file_info["ext"] = $file_extension;
    return $file_info;
}

/**
 * Create image object from a file with correct mime type
 * 
 * @param string $path
 * @param string $mime_type
 * @throws \Exception
 * @return GdImage
 */
function create_image_from_file(string $path, string $mime_type): GdImage
{
    $image = match ($mime_type) {
        'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
        'image/png' => imagecreatefrompng($path),
        'image/gif' => imagecreatefromgif($path),
        default => false,
    };
    if (!$image) {
        throw new Exception("Echec de la création de l'image");
    }
    return $image;
}

function save_image(GdImage $image, string $destination, string $mime_type)
{
    // Create the image file to destination by mime type
    $success = match ($mime_type) {
        'image/jpeg', 'image/jpg' => imagejpeg($image, $destination),
        'image/png' => imagepng($image, $destination),
        'image/gif' => imagegif($image, $destination),
        default => false,
    };
    if (!$success) {
        throw new Exception("Echec de la sauvegarde de l'image");
    }
}

function resize_image(array $file, array $file_info): GdImage
{
    $new_width = 300;
    $new_height = 400;

    // Create new image object with defined size
    $dest = imagecreatetruecolor($new_width, $new_height);

    // Create image object from the file uploaded
    $source = create_image_from_file($file['tmp_name'], $file_info['mime']);

    // Copy image uploaded to new image object with new size
    if (!imagecopyresampled($dest, $source, 0, 0, 0, 0, $new_width, $new_height, $file_info[0], $file_info[1])) {
        throw new Exception("Echec du resize de l'image");
    }

    // Clean memory
    imagedestroy($source);
    return $dest;
}

function upload_cover_image(): string|null
{
    // return null if no file is uploaded
    if (!isset($_FILES["cover_img"]) || $_FILES["cover_img"]["error"] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    // Check if directory exist
    if (!is_dir(UPLOAD_PATH)) {
        if (!mkdir(UPLOAD_PATH, 0755, true)) {
            throw new Exception("Failed to create uploads/covers directories");
        }
    }
    $file = $_FILES["cover_img"];

    // Check if the image is valid
    $file_info = validate_upload($file);

    // Create the image object with the new size
    $image = resize_image($file, $file_info);


    $filename = uniqid() . '.' . $file_info['ext'];
    $destination = UPLOAD_PATH . '/' . $filename;

    // save image to destination
    save_image($image, $destination, $file_info['mime']);

    // clean memory
    imagedestroy($image);
    return $filename;
}

function get_page_url(int $page): string
{
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['url']);
    if (isset($get['page']) && $page == 1) {
        unset($get['page']);
    } else {
        $get['page'] = $page;
    }
    $query = http_build_query($get);
    if (!empty($query)) {
        $uri .= "?$query";
    }
    return $uri;
}

function dd(mixed $value)
{
    echo "<pre><code>";
    print_r($value);
    echo "</code></pre>";
    die();
}

function upload_cover_from_url(string $url): ?string
{
    if (empty($url)) {
        return null;
    }

    // Check if directory exist
    if (!is_dir(UPLOAD_PATH)) {
        if (!mkdir(UPLOAD_PATH, 0755, true)) {
            throw new Exception("Failed to create uploads/covers directories");
        }
    }

    // Download image content
    $image_content = @file_get_contents($url);
    if ($image_content === false) {
        throw new Exception("Impossible de télécharger l'image depuis l'URL: $url");
    }

    // Create temporary file
    $tmp_file = tempnam(sys_get_temp_dir(), 'cover_');
    file_put_contents($tmp_file, $image_content);

    // Validate image type
    $file_info = getimagesize($tmp_file);
    if ($file_info === false) {
        unlink($tmp_file);
        throw new Exception("Le fichier téléchargé n'est pas une image valide");
    }

    $file_mime_type = $file_info["mime"];
    $allowed_types = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($file_mime_type, $allowed_types)) {
        unlink($tmp_file);
        throw new Exception("Type de fichier non valide (formats acceptés : jpg, png, gif).");
    }

    // Resize image
    $image = resize_image(
        ["tmp_name" => $tmp_file], // mimic $_FILES
        $file_info
    );

    // Generate unique filename
    $ext = match ($file_mime_type) {
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/gif" => "gif",
    };
    $filename = uniqid() . '.' . $ext;
    $destination = UPLOAD_PATH . '/' . $filename;

    // Save image
    save_image($image, $destination, $file_mime_type);

    // Clean up
    imagedestroy($image);
    unlink($tmp_file);

    return $filename;
}


function get_books_genres()
{
    $genre_enum = [
        'Roman',
        'Policier',
        'Biographie',
        'Histoire',
        'Fantaisie',
        'Épouvante',
        'Aventures',
        'Psychologie',
        'Science Fiction',
        'Thriller-Suspense',
        'Bande Dessinée',
    ];
    return $genre_enum;
}
function get_books_fields()
{
    $all_data = [
        "title",
        "genre",
        "stock",
        "author",
        "isbn",
        "pages",
        "published_year",
        "summary",
    ];
    return $all_data;
}

function get_movies_genres()
{
    $genre_enum = [
        'Action',
        'Comédie',
        'Documentaire',
        'Drame',
        'Fantaisie',
        'Horreur',
        'Comédie Musicale',
        'Mystère',
        'Romance',
        'Science Fiction',
        'Thriller-Suspense',
        'Western',
    ];
    return $genre_enum;
}
function get_games_fields()
{
    $all_data = [
        "title",
        "genre",
        "stock",
        "editor",
        "plateform",
        "pegi",
        "description",
    ];
    return $all_data;
}
function get_games_genres()
{
    $genre_enum = [
        'FPS',
        'MMO',
        'MOBA',
        'RPG'
    ];
    return $genre_enum;
}

function get_games_plateforms()
{
    $plateform_enum = [
        'PC',
        'PlayStation',
        'Xbox',
        'Nintendo',
        'Mobile',
    ];
    return $plateform_enum;
}
function get_games_pegis()
{
    $pegi_enum = [
        '3',
        '7',
        '12',
        '16',
        '18',
    ];
    return $pegi_enum;
}

function get_movies_fields()
{
    $all_data = [
        "title",
        "genre",
        "stock",
        "director",
        "duration",
        "published_year",
        "synopsis",
        "certification",
    ];
    return $all_data;
}
function get_movies_certifications()
{
    $certification_enum = [
        'Tous publics',
        '-12',
        '-16',
        '-18',
    ];
    return $certification_enum;
}

function is_admin()
{
    if (is_logged_in() && isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
        return true;
    }
    return false;
}

function validate_password(string $str): bool
{
    $has_uppercase = false;
    $has_lowercase = false;
    $has_numeric = false;
    $str_array = mb_str_split($str);

    if (strlen($str) < 8)
        return false;

    foreach ($str_array as $c) {
        if (ctype_upper($c)) {
            $has_uppercase = true;
        } else if (ctype_lower($c)) {
            $has_lowercase = true;
        } else if (ctype_digit($c)) {
            $has_numeric = true;
        }
    }

    return $has_uppercase && $has_lowercase && $has_numeric;
}

function crop_string(string $str, int $max_len)
{
    if (strlen($str) > $max_len) {
        return substr($str, 0, $max_len) . "...";
    }
    return $str;
}

// function get_time_before_return(string $borrow_date)
// {
//     $return_date = date_create($borrow_date)->modify("+" . RETURN_DELAY . "days");
//     $now = date_create();
//     $time_left = date_diff($now, $return_date);
//     $late = $time_left->invert ? "Il y a" : "Dans";
//     $units = [
//         'y' => ['an', 'ans'],
//         'm' => ['mois', 'mois'],
//         'd' => ['jour', 'jours'],
//         'h' => ['heure', 'heures'],
//         'i' => ['minute', 'minutes'],
//         's' => ['seconde', 'secondes'],
//     ];

//     foreach ($units as $key => [$singular, $plural]) {
//         $value = $time_left->$key;
//         if ($value > 0) {
//             $label = $value === 1 ? $singular : $plural;
//             return "$late $value $label";
//         }
//     }
//     return "maintenant";
// }

function get_estimated_return_date(string $borrow_date)
{
    $return_date = date_create($borrow_date)->modify("+" . RETURN_DELAY . "days");
    $formated = $return_date->format('d/m/Y');
    return $formated;
}


// Validations

function get_error_by_field(string $field): string
{
    $errors = [
        'title' => 'Titre invalide (nombre de caractères entre 1 et 200)',
        'genre' => 'Genre invalide',
        'stock' => 'Le stock doit être un entier positif',
        'author' => 'Auteur invalide (nombre de caractères entre 2 et 100)',
        'isbn' => 'ISBN invalide (10 ou 13 chiffres) ou déjà utilisé',
        'pages' => 'Le nombre de pages doit être un entier entre 1 et 9999',
        'published_year' => 'L\'année de publication doit être comprise entre 1900 et l\'année actuelle',
        'summary' => 'Le résumé doit comprendre maximum 3000 caractères',
        'director' => 'Réalisateur invalide (nombre de caractères entre 2 et 100)',
        'duration' => 'La durée du film doit être un entier entre 1 et 999',
        'synopsis' => 'Le synopsis doit comprendre maximum 3000 caractères',
        'editor' => 'Éditeur invalide (nombre de caractères entre 2 et 100)',
        'description' => 'La description doit comprendre maximum 3000 caractères',
        'pegi' => 'Certification PEGI invalide',
        'plateform' => 'Plateforme invalide',
        'certification' => 'Certification invalide'
    ];
    return $errors[$field] ?? "Aucune erreur ne correspond à ce champ";
}

function int_validation(string $nb, ?int $min = null, ?int $max = null): bool
{
    $nb_int = filter_var($nb, FILTER_VALIDATE_INT);

    if ($nb_int === false) {
        return false;
    }

    if ($min != null && $nb_int < $min) {
        return false;
    }

    if ($max != null && $nb_int > $max) {
        return false;
    }

    return true;
}

function string_range_validation(string $str, ?int $min = null, ?int $max = null): bool
{
    $len = strlen($str);
    if ($min != null && $len < $min) {
        return false;
    }
    if ($max != null && $len > $max) {
        return false;
    }
    return true;
}

function isbn_validation(string $isbn, $is_edit = false): bool
{
    if (!is_numeric($isbn)) {
        return false;
    }

    $len = strlen($isbn);

    if ($len !== 10 && $len !== 13) {
        return false;
    }

    if ($is_edit) {
        if (!check_isbn_unique($isbn, get('id'))) {
            return false;
        }
    } else {
        if (!check_isbn_unique($isbn)) {
            return false;
        }
    }

    return true;
}

function book_validation(bool $is_edit = false)
{
    $fields = get_books_fields();
    $genres = get_books_genres();
    $inputs = [];
    $is_valid = true;

    foreach ($fields as $field) {
        if (!isset($field)) {
            set_flash('error', "$field n'est pas renseigné");
            $is_valid = false;
            continue;
        }

        $input = trim(post($field));
        $valid = match ($field) {
            'title' => string_range_validation($input, 1, 200),
            'genre' => in_array($input, $genres),
            'stock' => int_validation($input, $is_edit ? 0 : 1),
            'author' => string_range_validation($input, 2, 100),
            'isbn' => isbn_validation($input, $is_edit),
            'pages' => int_validation($input, 1, 9999),
            'published_year' => int_validation($input, 1900, date('Y')),
            'summary' => string_range_validation($input, 0, 3000)
        };
        if (!$valid) {
            $is_valid = false;
            set_flash('error', get_error_by_field($field));
        }
        $inputs[$field] = $input;
    }
    return [$is_valid, $inputs];
}

function movie_validation(bool $is_edit = false)
{
    $fields = get_movies_fields();
    $genres = get_movies_genres();
    $certifications = get_movies_certifications();
    $inputs = [];
    $is_valid = true;

    foreach ($fields as $field) {
        if (!isset($field)) {
            set_flash('error', "$field n'est pas renseigné");
            $is_valid = false;
            continue;
        }

        $input = trim(post($field));
        $valid = match ($field) {
            'title' => string_range_validation($input, 1, 200),
            'genre' => in_array($input, $genres),
            'stock' => int_validation($input, $is_edit ? 0 : 1),
            'director' => string_range_validation($input, 2, 100),
            'duration' => int_validation($input, 1, 999),
            'published_year' => int_validation($input, 1900, date('Y')),
            'certification' => in_array($input, $certifications),
            'synopsis' => string_range_validation($input, 0, 3000)
        };
        if (!$valid) {
            $is_valid = false;
            set_flash('error', get_error_by_field($field));
        }
        $inputs[$field] = $input;
    }
    return [$is_valid, $inputs];
}

function game_validation(bool $is_edit = false)
{
    $fields = get_games_fields();
    $genres = get_games_genres();
    $plateforms = get_games_plateforms();
    $pegis = get_games_pegis();
    $inputs = [];
    $is_valid = true;

    foreach ($fields as $field) {
        if (!isset($field)) {
            set_flash('error', "$field n'est pas renseigné");
            $is_valid = false;
            continue;
        }

        $input = trim(post($field));
        $valid = match ($field) {
            'title' => string_range_validation($input, 1, 200),
            'genre' => in_array($input, $genres),
            'stock' => int_validation($input, $is_edit ? 0 : 1),
            'editor' => string_range_validation($input, 2, 100),
            'duration' => int_validation($input, 1, 999),
            'pegi' => in_array($input, $pegis),
            'plateform' => in_array($input, $plateforms),
            'description' => string_range_validation($input, 0, 3000)
        };
        if (!$valid) {
            $is_valid = false;
            set_flash('error', get_error_by_field($field));
        }
        $inputs[$field] = $input;
    }
    return [$is_valid, $inputs];
}

enum MediaType: string
{
    case Book = "Book";
    case Movie = "Movie";
    case Game = "Game";
}
