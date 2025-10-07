<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'voyages');
define('DB_USER', 'root');
define('DB_PASS', 'bbad4ngd25quam7mze72');
define('DB_CHARSET', 'utf8');

// Configuration générale de l'application

define('BASE_URL', "http://localhost/Voyages-Livre-dor/public");

define('APP_NAME', "Voyages / Livre d'or");
define('APP_VERSION', '1.0.0');

// Configuration des chemins
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers');
define('MODEL_PATH', ROOT_PATH . '/models');
define('VIEW_PATH', ROOT_PATH . '/views');
define('INCLUDE_PATH', ROOT_PATH . '/includes');
define('CORE_PATH', ROOT_PATH . '/core');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Added configuratinons
define('LOG_PATH', ROOT_PATH . '/logs');
define('UPLOAD_URL', "http://localhost/Voyages-Livre-dor/uploads/covers");
define('UPLOAD_PATH', ROOT_PATH . '/uploads/covers');
// 2mo
define('UPLOAD_MAX_SIZE', 2097152);
define('MAX_MEDIA_PER_PAGE', 12);
define('DEBUG', true);
// In days
define('RETURN_DELAY', 14);
// In seconds
define('SESSION_TIMEOUT', 7200);
