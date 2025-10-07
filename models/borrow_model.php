<?php


function get_borrow_count_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(id) FROM borrowed WHERE user_id = ? AND return_date is NULL";
    return db_select_one($query, [$user_id])["COUNT(id)"];
}

function get_media_stock_by_id(int $media_id)
{
    $query = "SELECT stock FROM medias WHERE id = ?";
    return db_select_one($query, [$media_id])["stock"];
}

function decrement_media_stock(int $media_id)
{
    $query = "UPDATE medias SET stock = stock - 1 WHERE id = ?";
    return db_execute($query, [$media_id]);
}

function add_borrowed_media(int $media_id, int $user_id)
{
    $query = "INSERT INTO borrowed (media_id, user_id) VALUES (?,?)";
    db_execute($query, [$media_id, $user_id]);
}

function borrow_media(int $media_id, int $user_id)
{
    db_begin_transaction();
    try {
        //check media already borrowed by this user
        if (is_media_already_borrowed_by_user($media_id, $user_id)) {
            throw new Exception("Media deja emprunté");
        }
        decrement_media_stock($media_id);
        add_borrowed_media($media_id, $user_id);
        db_commit();
        return true;
    } catch (Exception $e) {
        $msg = $e->getMessage();
        set_flash('error', $msg);
        error_logging(ErrorType::Error, $msg);
        db_rollback();
    }
    return false;
}
function is_media_already_borrowed_by_user(int $media_id, int $user_id)
{
    $query = "SELECT id FROM borrowed WHERE user_id = ? AND media_id = ? AND return_date is NULL";
    $ret = db_select_one($query, [$user_id, $media_id]);
    return (bool) $ret;
}
function is_media_already_borrowed(int $media_id)
{
    $query = "SELECT id FROM borrowed WHERE media_id = ? AND return_date is NULL";
    $ret = db_select_one($query, [$media_id]);
    return (bool) $ret;
}

// Incrémente le stock 1 par 1 dans la table medias
function increment_media_stock(int $media_id)
{
    $query = "UPDATE medias SET stock = stock + 1 WHERE id = ?";
    return db_execute($query, [$media_id]);
}

function get_current_borrow_list_by_user_id(int $user_id)
{
    $query = "SELECT * FROM borrowed b LEFT JOIN medias m ON m.id = b.media_id WHERE b.user_id = ? AND return_date is NULL";
    return db_select($query, [$user_id]);
}

function get_borrows_details_by_user(int $user_id): array
{
    $query = "SELECT b.id, b.media_id, b.start, m.title, m.type FROM borrowed as b LEFT JOIN medias m ON m.id = media_id WHERE user_id = ? AND return_date is NULL";
    return db_select($query, [$user_id]);
}

function get_borrow_history_list_by_user_id(int $user_id, $limit = null, $offset = 0)
{
    $query = "SELECT * FROM borrowed b LEFT JOIN medias m ON m.id = b.media_id WHERE b.user_id = ? AND return_date is NOT NULL ORDER BY start DESC";
    if ($limit !== null) {
        $query .= " LIMIT $offset, $limit";
    }


    return db_select($query, [$user_id]);
}

// MAJ de la table borrowed sans rien changer car MAJ automatique de la valeur DATE DE RETOUR
// au moment de l'update de la table ???
function return_borrowed_media($media_id, $user_id)
{
    $query = "UPDATE borrowed SET return_date = NOW() WHERE media_id = ? AND user_id = ? AND return_date is NULL";
    db_execute($query, [$media_id, $user_id]);
}

// Fonction qui gere les deux updates des deux tables MAJ
// dans le cadre d'un retour média
// Si probleme, on rollback
function return_media(int $media_id, int $user_id)
{
    db_begin_transaction();
    try {
        // check if media is not already borrowed by user
        if (!is_media_already_borrowed_by_user($media_id, $user_id)) {
            throw new Exception("Media not borrowed : $media_id");
        }
        return_borrowed_media($media_id, $user_id);
        increment_media_stock($media_id);
        db_commit();
        return true;
    } catch (Exception $e) {
        $msg = "Failed to borrow media" . $media_id . " by user " . $user_id . " | " . $e->getMessage();
        error_logging(ErrorType::Error, $msg);
        db_rollback();
    }
    return false;
}


function get_borrow_history_count_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(b.id) FROM borrowed b WHERE b.user_id = ? AND return_date is NOT NULL";
    return db_select_one($query, [$user_id])["COUNT(b.id)"];
}

function get_total_borrow_count_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(id) FROM borrowed WHERE user_id = ?";
    return db_select_one($query, [$user_id])["COUNT(id)"];
}

function get_late_return_total_by_user_id(int $user_id)
{
    $query = "SELECT COUNT(id) 
    FROM borrowed 
    WHERE DATEDIFF(NOW(), start) > ? AND return_date is NULL AND user_id = ?
    OR DATEDIFF(return_date, start) > ? AND user_id = ?";
    return db_select_one($query, [RETURN_DELAY, $user_id, RETURN_DELAY, $user_id])["COUNT(id)"];
}

function get_late_return_list()
{
    $query = "SELECT b.start ,m.title, u.name
    FROM borrowed b
    LEFT JOIN medias m ON m.id = b.media_id
    LEFT JOIN users u ON u.id = b.user_id
    WHERE DATEDIFF(NOW(), start) > ? AND b.return_date is NULL";
    return db_select($query, [RETURN_DELAY]);
}
