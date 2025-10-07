<?php

function goldenbook_comment()
{

    $_SESSION['message'] = '';
    $data = [
        'title' => 'Connexion',
        'stylesheets' => [
            'assets/css/voyages.css',
        ]
    ];
    if (is_post()) {

        if (isset($_POST['ok']) && $_POST['comment'] !== "") {
            if (verify_csrf_token($_POST["csrf_token"])) {
                $user = User::logged($_SESSION['user']);
                post_comment($_POST['comment'], $user->getId(), date('Y-m-d H:i:s'));
                set_flash('success','Commentaire posté avec succès');
            }
        }
    }

        if ($_SESSION['user']['logged'] !== true) {
            redirect('auth/login');
        } else {
            load_view_with_layout('goldenbook/comment', $data);
        }
}

function goldenbook_index()
{
    $_SESSION['message'] = '';
    $comments = get_comments();

    $data = [
        'title' => 'Connexion',
        'stylesheets' => [
            'assets/css/voyages.css',
        ],
        'comments' => $comments,
    ];

    load_view_with_layout('goldenbook/index', $data);
}