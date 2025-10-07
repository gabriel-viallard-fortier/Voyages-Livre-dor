<div class="show-card">
    <a href="medias">
        <h1>Gestion des médias</h1>
    </a>
    <div class="add-media-container">
        <a href="add_book" class="btn btn-primary">Ajouter un livre</a>
        <a href="add_movie" class="btn btn-primary">Ajouter un film</a>
        <a href="add_game" class="btn btn-primary">Ajouter un jeu</a>
    </div>

    <?php include VIEW_PATH . '/search-bar/search-bar.php' ?>
    <table class="user-table">
        <thead>
            <th class="text-white">Id</th>
            <th class="text-white">Stock</th>
            <th class="text-white">Type</th>
            <th class="text-white">Titre</th>
            <th class="text-white" colspan="2">Action</th>
        </thead>
        <tbody>
            <?php foreach ($medias as $media): ?>
                <tr>
                    <td data-label="Id" class="text-white"><?= $media['id'] ?></td>
                    <td data-label="Stock" class="text-white"><?= $media['stock'] ?></td>
                    <td data-label="Type" class="text-white"><?= $media['type'] ?></td>
                    <td data-label="Titre"><a class="table-ref"
                            href="<?= get_media_url($media['id'], $media['type']) ?>"><?= $media['title'] ?></a></td>
                    <td class="no-label"><a class="btn btn-primary"
                            href="<?= get_edit_url($media['id'], $media['type']) ?>">Modifier</a>
                    </td>
                    <td class="no-label">
                        <button popovertarget="confirm-popover-<?= $media['id'] ?>" class="btn btn-alert">Supprimer</button>
                        <div class="confirm-popover" popover="hint" id="confirm-popover-<?= $media['id'] ?>">
                            <div class="confirm-container">
                                <div class="confirm-title">Confirmer la suppression ?</div>
                                <div class="confirm-buttons">
                                    <form action="<?= url("admin/delete_media") ?>" method="post">
                                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                        <button class="btn btn-primary" name="id" value="<?= $media['id'] ?>">OUI</button>
                                    </form>
                                    <button class="btn btn-alert" popovertarget="confirm-popover-<?= $media['id'] ?>"
                                        popovertargetaction="hide">NON</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
</div>