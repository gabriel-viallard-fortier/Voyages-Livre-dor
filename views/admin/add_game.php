<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><?= $data['action'] ?> un jeu</h2>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du jeu" value="<?php if (isset($entries['title']))
                                                                                                            e($entries['title']); ?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du jeu</option>
                    <?php foreach ($data['genre_enum'] as $genre): ?>
                        <option <?php if (isset($entries['genre']) && $entries['genre'] === $genre)
                                    echo 'selected'; ?>
                            value="<?= $genre ?>"><?= $genre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required placeholder="Stock" value="<?php if (isset($entries['stock']))
                                                                                                        e($entries['stock']); ?>">
            </div>

            <div class="form-group">
                <label for="editor">Éditeur</label>
                <input type="text" id="editor" name="editor" required placeholder="Éditeur" value="<?php if (isset($entries['editor']))
                                                                                                        e($entries['editor']); ?>">
            </div>

            <div class="form-group">
                <label for="plateform">Plateforme</label>
                <select id="plateform" name="plateform" required>
                    <option value="">Plateforme</option>
                    <?php foreach ($data['plateform_enum'] as $plateform): ?>
                        <option <?php if (isset($entries['plateform']) && $entries['plateform'] === $plateform)
                                    echo 'selected'; ?> value="<?= $plateform ?>"><?= $plateform ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="pegi">Pegi</label>
                <select id="pegi" name="pegi" required value="<?php if (isset($entries['pegi']))
                                                                    echo $entries['pegi']; ?>">
                    <option value="pegi">Pegi</option>
                    <?php foreach ($data['pegi_enum'] as $pegi): ?>
                        <option <?php if (isset($entries['pegi']) && $entries['pegi'] === $pegi)
                                    echo 'selected'; ?>
                            value="<?= $pegi ?>"><?= $pegi ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" maxlength="3000"><?php if (isset($entries['description']))
                                                                                                                e($entries['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover_img">
            </div>

            <button type="submit" class="btn btn-secondary btn-full">
                <i class="fas fa-user-plus"></i>
                <?= $data['action'] ?>
            </button>
        </form>

    </div>
</div>