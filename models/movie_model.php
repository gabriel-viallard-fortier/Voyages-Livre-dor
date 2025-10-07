<?php

function get_movie_by_id(int $id)
{
    $query = "SELECT * FROM  movies mo LEFT JOIN medias m ON m.id = mo.id WHERE mo.id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}

function insert_new_movie(int $media_id, array $movie_data)
{
    $query = "INSERT INTO movies 
        (id, director, duration, published_year, synopsis, certification)
        VALUES(?,?,?,?,?,?)";

    return db_execute(
        $query,
        [
            $media_id,
            $movie_data['director'],
            $movie_data['duration'],
            $movie_data['published_year'],
            $movie_data['synopsis'],
            $movie_data['certification'],
        ]
    );
}
function update_movie(int $movie_id, array $movie_data)
{
    $query = "UPDATE movies SET 
            director = ?,
            duration = ?,
            published_year = ?,
            synopsis = ?
            WHERE id = ?";

    return db_execute($query, [
        $movie_data['director'],
        $movie_data['duration'],
        $movie_data['published_year'],
        $movie_data['synopsis'],
        $movie_id,
    ]);
}
