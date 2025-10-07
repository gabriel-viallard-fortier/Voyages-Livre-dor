USE php_mvc_app;

CREATE TABLE IF NOT EXISTS medias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL CHECK (LENGTH(title) > 0 AND LENGTH(title) <= 200),
    genre ENUM(
        'Roman',
        'Policier',
        'Biographie',
        'Histoire',
        'Épouvante',
        'Aventures',
        'Psychologie',
        'Bande Dessinée',
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
        'FPS',
        'MMO',
        'MOBA',
        'RPG'
    ) NOT NULL,
    type ENUM('Book', 'Movie', 'Game') NOT NULL,
    cover_img VARCHAR(200) DEFAULT NULL,
    stock INT NOT NULL
);

CREATE TABLE IF NOT EXISTS books (
    id INT NOT NULL UNIQUE,
    author VARCHAR(100) NOT NULL CHECK (LENGTH(author) >= 2 AND LENGTH(author) <= 100),
    isbn VARCHAR(13) NOT NULL UNIQUE CHECK (LENGTH(isbn) = 10 OR LENGTH(isbn) = 13),
    pages INT NOT NULL CHECK (pages >= 1 AND pages <= 9999),
    published_year INT NOT NULL CHECK (published_year >= 1900),
    summary TEXT NOT NULL CHECK (LENGTH(summary) <= 3000),
    FOREIGN KEY(id) REFERENCES medias(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS movies (
    id INT NOT NULL UNIQUE,
    director VARCHAR(100) NOT NULL CHECK (LENGTH(director) >= 2 AND LENGTH(director) <= 100),
    duration INT NOT NULL CHECK (duration > 0 AND duration <= 999),
    published_year INT NOT NULL CHECK (published_year >= 1900),
    synopsis TEXT NOT NULL CHECK (LENGTH(synopsis) <= 3000),
    certification ENUM('Tous publics', '-12', '-16', '-18') NOT NULL,
    FOREIGN KEY(id) REFERENCES medias(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS games (
    id INT NOT NULL UNIQUE,
    editor VARCHAR(100) NOT NULL CHECK (LENGTH(editor) >= 2 AND LENGTH(editor) <= 100),
    plateform ENUM('PC', 'PlayStation', 'Xbox', 'Nintendo', 'Mobile') NOT NULL,
    pegi ENUM('3', '7', '12', '16', '18') NOT NULL,
    description TEXT NOT NULL CHECK (LENGTH(description) <= 3000),
    FOREIGN KEY(id) REFERENCES medias(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS borrowed (
    id INT AUTO_INCREMENT PRIMARY KEY,
    media_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY(media_id) REFERENCES medias(id) ON DELETE CASCADE,
    FOREIGN KEY(user_id) REFERENCES users(id),
    start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    return_date TIMESTAMP NULL DEFAULT NULL
);