<?php

function debug_index()
{

    if (is_post()) {
        if (isset($_POST["add_medias"])) {
            $medias = include ROOT_PATH . "/debug/db_data.php";
            foreach ($medias as $media) {
                try {
                    $media["cover_img"] = upload_cover_from_url($media["cover_img"]);
                    if ($media["type"] === 'Game') {
                        insert_new_media($media, MediaType::Game);
                    } else if ($media['type'] === 'Movie') {
                        insert_new_media($media, MediaType::Movie);
                    } else if ($media['type'] === 'Book') {
                        insert_new_media($media, MediaType::Book);
                    }
                } catch (Exception $e) {
                    error_logging(ErrorType::Error, $e->getMessage());
                }
            }
        } else if (isset($_POST['add_users'])) {
            $names = [
                "Olivia",
                "Liam",
                "Sophia",
                "Noah",
                "Isabella",
                "Mason",
                "Ava",
                "Ethan",
                "Mia",
                "James",
                "Charlotte",
                "Benjamin",
                "Amelia",
                "Lucas",
                "Harper",
                "Henry",
                "Ella",
                "Alexander",
                "Aria",
                "Daniel"
            ];
            for ($i = 0; $i < 50; $i++) {
                $random_name = $names[rand(0, count($names) - 1)];
                $email = $random_name . uniqid() . "@example.com";
                try {
                    create_user($random_name, $email, "password123");
                } catch (Exception $e) {
                    error_logging(ErrorType::Error, $e->getMessage());
                }
            }

        } elseif (isset($_POST['clean_medias'])) {
            try {
                db_execute('DELETE FROM borrowed');
                db_execute('DELETE FROM medias');
                set_flash('success', 'Medias cleaned');
            } catch (Exception $e) {
                set_flash('error', $e->getMessage());
            }
        } elseif (isset($_POST['clean_users'])) {
            try {
                db_execute('DELETE FROM borrowed');
                db_execute('DELETE FROM users');
                set_flash('success', 'Users cleaned');
            } catch (Exception $e) {
                set_flash('error', $e->getMessage());
            }
        }
    }
    load_view_with_layout('debug/debug');

}
