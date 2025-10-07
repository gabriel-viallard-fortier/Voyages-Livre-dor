<?php
// Modèle pour les utilisateurs

/**
 * Récupère un utilisateur par son email
 */
function get_user_by_email($email)
{
    $query = "SELECT * FROM users WHERE email = ? AND active = TRUE LIMIT 1";
    return db_select_one($query, [$email]);
}

/**
 * Récupère un utilisateur par son ID
 */
function get_user_by_id($id)
{
    $query = "SELECT * FROM users WHERE id = ? AND active = TRUE LIMIT 1";
    return db_select_one($query, [$id]);
}

/**
 * Crée un nouvel utilisateur
 */
function create_user($name, $email, $password)
{
    $hashed_password = hash_password($password);
    $query = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";

    if (db_execute($query, [$name, $email, $hashed_password])) {
        return db_last_insert_id();
    }

    return false;
}

/**
 * Met à jour un utilisateur
 */
function update_user($id, $name, $email)
{
    $query = "UPDATE users SET name = ?, email = ?, updated_at = NOW() WHERE id = ?";
    return db_execute($query, [$name, $email, $id]);
}

/**
 * Met à jour le mot de passe d'un utilisateur
 */
function update_user_password($id, $password)
{
    $hashed_password = hash_password($password);
    $query = "UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?";
    return db_execute($query, [$hashed_password, $id]);
}

/**
 * Supprime un utilisateur
 */
function delete_user($id)
{
    if (current_user_id() != $id && get_user_by_id($id)) {
        if (get_borrow_count_by_user_id($id) > 0) {
            return false;
        }
        $query = "UPDATE users SET name = ?, email = ?, password = ?, updated_at = NOW(), active = FALSE WHERE id = ?";
        return db_execute($query, ["", $id, "", $id]);
    }
    return false;
}

/**
 * Récupère tous les utilisateurs
 */
function get_all_users($limit = null, $offset = 0)
{
    $query = "SELECT id, name, email, created_at FROM users WHERE active = TRUE ORDER BY created_at DESC";

    if ($limit !== null) {
        $query .= " LIMIT $offset, $limit";
    }

    return db_select($query);
}

/**
 * Compte le nombre total d'utilisateurs
 */
function count_users()
{
    $query = "SELECT COUNT(*) as total FROM users WHERE active = TRUE";
    $result = db_select_one($query);
    return $result['total'] ?? 0;
}

/**
 * Vérifie si un email existe déjà
 */
function email_exists($email, $exclude_id = null)
{
    $query = "SELECT COUNT(*) as count FROM users WHERE email = ?";
    $params = [$email];

    if ($exclude_id) {
        $query .= " AND id != ?";
        $params[] = $exclude_id;
    }

    $result = db_select_one($query, $params);
    return $result['count'] > 0;
}