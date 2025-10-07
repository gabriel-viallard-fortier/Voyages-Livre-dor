<?php

// fonction pour ajouter les médias.

function insert_new_book(int $media_id, array $book_data)
{
    $query = "INSERT INTO books 
        (id, author, isbn, pages, published_year, summary)
        VALUES (?,?,?,?,?,?)";

    return db_execute(
        $query,
        [
            $media_id,
            $book_data['author'],
            $book_data['isbn'],
            $book_data['pages'],
            $book_data['published_year'],
            $book_data['summary'],
        ]
    );
}

// tableau DB dans lequel le model vient selectionner selon l'id.


function get_book_by_id(int $id)
{
    $query = "SELECT * FROM  books b LEFT JOIN medias m ON m.id = b.id WHERE b.id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}




function check_isbn_unique(string $isbn, $id = null)
{

    $query = "SELECT id FROM books WHERE isbn = ?";
    $result = db_select_one($query, [$isbn]);


    // Si ISBN non présent dans la DB, retourne vrai
    // Si présent mais correspondant à l'ID donné, retourne vrai
    // Sinon, retourne faux, isbn déja  utilisé

    if (empty($result)) {
        return true;
    } elseif ($result['id'] === intval($id)) {
        return true;
    } else {
        return false;
    }
}

function update_book(int $book_id, array $book_data)
{
    $query = "UPDATE books SET 
            author = ?,
            isbn = ?,
            pages = ?,
            published_year = ?,
            summary = ?
            WHERE id = ?";

    return db_execute($query, [
        $book_data["author"],
        $book_data["isbn"],
        $book_data["pages"],
        $book_data["published_year"],
        $book_data["summary"],
        $book_id,
    ]);
}

