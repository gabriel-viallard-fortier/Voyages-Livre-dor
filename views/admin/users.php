<div class="user-page">
    <a href="users">
        <h1>Gestion des utilisateurs</h1>
    </a>
    <div class="user-table-wrapper">
        <table class="user-table">
            <thead>
                <?php foreach ($fields as $field): ?>
                    <th><?= $field ?></th>
                <?php endforeach; ?>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td data-label="Id"><?php e($user['id']) ?></td>
                        <td data-label="Nom"><?php e($user['name']) ?></td>
                        <td data-label="Email"><?php e($user['email']) ?></td>
                        <td data-label="Création"><?= format_date($user['created_at']) ?></td>
                        <td data-label="Emprunts en cours">
                            <?php
                            $borrow_count = get_borrow_count_by_user_id($user["id"]);
                            $borrow_popover_id = "borrow_popover_" . $user["id"];
                            ?>
                            <div class="borrow_count_and_detail_btn">
                                <?php if ($borrow_count > 0): ?>
                                    <button class="btn btn-primary"
                                        popovertarget="<?= $borrow_popover_id ?>"><?= $borrow_count ?></button>
                                    <!-- Popover of the user borrow list -->
                                    <div id="<?= $borrow_popover_id ?>" class="borrow-list" popover>
                                        <?php $borrows = get_borrows_details_by_user($user["id"]); ?>
                                        <p>Liste d'emprunts de <?php e($user['name']) ?></p>
                                        <table class="user-table">
                                            <thead>
                                                <th>Media id</th>
                                                <th>Type</th>
                                                <th>Titre</th>
                                                <th>Date d'emprunt</th>
                                                <th>Retour prévu</th>
                                                <th>Forcer le retour</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($borrows as $borrow): ?>
                                                    <?php $estimated_return = get_estimated_return_date($borrow['start']); ?>
                                                    <tr>
                                                        <td data-label="Media id"><?php e($borrow['media_id']) ?></td>
                                                        <td data-label="Type"><?php e($borrow['type']) ?></td>
                                                        <td data-label="Titre"><?php e($borrow['title']) ?></td>
                                                        <td data-label="Date d'emprunt"><?= format_date($borrow['start']) ?></td>
                                                        <td data-label="Retour prévu"><?php e($estimated_return) ?></td>
                                                        <form action="<?= url("admin/force_return") ?>" method="post">
                                                            <input type="hidden" name="csrf_token"
                                                                value="<?php echo csrf_token(); ?>">
                                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                            <input type="hidden" name="media_id" value="<?= $borrow['media_id'] ?>">
                                                            <input type="hidden" name="redirect" value="admin/users">
                                                            <td data-label="Forcer le retour"><button type="submit"
                                                                    class="btn btn-alert">Rendre</button></td>
                                                        </form>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p><?= $borrow_count ?></p>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td data-label="Stats">
                            <?php $stats_popover_id = "stats_popover_" . $user["id"]; ?>
                            <button class="btn btn-primary" popovertarget="<?= $stats_popover_id ?>">Voir</button>
                            <!-- Popover of the user stats -->
                            <div id="<?= $stats_popover_id ?>" class="stats-container" popover>
                                <p>Statistiques de <?php e($user['name']) ?></p>
                                <table class="user-table">
                                    <thead>
                                        <th>Total d'emprunts</th>
                                        <th>Taux de retard (%)</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_borrow = get_total_borrow_count_by_user_id($user['id']);
                                        $total_late_return = get_late_return_total_by_user_id($user['id']);
                                        $late_ret_percent = $total_borrow > 0 ? round($total_late_return * 100 / $total_borrow) : 0;
                                        ?>
                                        <tr>
                                            <td data-label="Total d'emprunts"><?= $total_borrow ?></td>
                                            <td data-label="Taux de retard (%)"><?= $late_ret_percent ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                        <?php if ($user['id'] != current_user_id()): ?>
                            <td class="no-label">
                                <button popovertarget="confirm-popover-<?= $user['id'] ?>"
                                    class="btn btn-alert">Supprimer</button>
                                <div class="confirm-popover" popover="hint" id="confirm-popover-<?= $user['id'] ?>">
                                    <div class="confirm-container">
                                        <div class="confirm-title">Confirmer la suppression ?</div>
                                        <div class="confirm-buttons">
                                            <form action="<?= url("admin/delete_user") ?>" method="post">
                                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                                <input type="hidden" name="redirect" value="admin/users">
                                                <button class="btn btn-primary" name="id"
                                                    value="<?= $user['id'] ?>">OUI</button>
                                            </form>
                                            <button class="btn btn-alert" popovertarget="confirm-popover-<?= $user['id'] ?>"
                                                popovertargetaction="hide">NON</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once VIEW_PATH . '/medias/pagination.php' ?>
</div>