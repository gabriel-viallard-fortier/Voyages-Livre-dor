<div class="user-page">
    <div class="admin-link-container">
        <a href="<?= url('admin/medias') ?>" class="btn btn-primary">Gestion des médias</a>
        <a href="<?= url('admin/users') ?>" class="btn btn-primary">Gestion des utilisateurs</a>
    </div>
    <div class="database-info-container">
        <h1>Infos sur la base de données</h1>
        <div class="database-info">
            <h4>Nombre total de médias dans la base de données : <?= get_media_count() ?></h4>
            <p>Dont <?= get_books_count() ?> livres,
                <?= get_movies_count() ?> films et
                <?= get_games_count() ?> jeux
            </p>
            <h4>Nombre total d'utilisateurs: <?= count_users() ?></h4>
        </div>
    </div>
    <!-- tableau de la liste des retards -->
    <div class="infos-container">
        <h1>Liste des retards</h1>
        <?php if (!empty($list)): ?>
            <table class="user-table">
                <thead>
                    <tr>

                        <th>Titre du medias</th>
                        <th>Nom de l'utilisateur</th>
                        <th>Date d'emprunt</th>
                        <th>Retour prévu</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach ($list as $elem): ?>

                        <tr>
                            <td data-label="Titre"><?= e($elem["title"]) ?></td>
                            <td data-label="Nom"><?= e($elem["name"]) ?></td>
                            <td data-label="Date d'emprunt"><?= e(format_date($elem["start"], $format = 'd/m/Y')) ?></td>
                            <td data-label="Retour prévu"> <?= e(get_estimated_return_date($elem['start'])); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        <?php else: ?>
            <p>Aucun retards</p>
        <?php endif ?>
    </div>
</div>