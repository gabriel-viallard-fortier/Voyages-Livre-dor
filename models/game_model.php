<?php

function get_game_by_id(int $id)
{
    $query = "SELECT * FROM  games g LEFT JOIN medias m ON m.id = g.id WHERE g.id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}

function insert_new_game(int $media_id, array $game_data)
{
    $query = "INSERT INTO games
        (id, editor, plateform, pegi, description)
        VALUES(?,?,?,?,?)";

    return db_execute(
        $query,
        [
            $media_id,
            $game_data['editor'],
            $game_data['plateform'],
            $game_data['pegi'],
            $game_data['description'],
        ]
    );
}

function update_game(int $game_id, array $game_data)
{
    $query = "UPDATE games SET 
            editor = ?,
            plateform = ?,
            pegi = ?,
            description = ?
            WHERE id = ?";

    return db_execute($query, [
        $game_data['editor'],
        $game_data['plateform'],
        $game_data['pegi'],
        $game_data['description'],
        $game_id,
    ]);
}
