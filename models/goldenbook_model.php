<?php
function post_comment($comment, $user_id, $date) {    
    $dbco = db_connect();
    
    $query = $dbco->prepare('INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?,?,?)');
    if ($query->execute(array($comment, $user_id, $date))) {
    return true;
    }
    return false;
}

function get_comments() 
{
    $dbco = db_connect();
    $query = 'SELECT users.login, commentaire, id_utilisateur, date FROM commentaires LEFT JOIN users ON commentaires.id_utilisateur = users.id ORDER BY commentaires.id DESC';
    $result = db_select($query);
    
    return $result;
}
