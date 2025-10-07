<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><?= $action ?> un film</h2>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du film" value="<?php if (isset($entries['title']))
                                                                                                            e($entries['title']); ?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option value="">Genre du film</option>
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
                <label for="director">Réalisateur</label>
                <input type="text" id="director" name="director" required placeholder="Réalisateur" value="<?php if (isset($entries['director']))
                                                                                                                e($entries['director']); ?>">
            </div>

            <div class="form-group">
                <label for="duration">Durée (minutes)</label>
                <input type="number" id="duration" name="duration" required placeholder="Durée" min="1" max="999" value="<?php if (isset($entries['duration']))
                                                                                                                                e($entries['duration']); ?>">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900" value="<?php if (isset($entries['published_year']))
                                                                            e($entries['published_year']); ?>">
            </div>

            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea id="synopsis" name="synopsis" placeholder="Synopsis du film" maxlength="3000"><?php if (isset($entries['synopsis']))
                                                                                                            e($entries['synopsis']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="certification">Certification</label>
                <select id="certification" name="certification" required>
                    <option value="">Certification</option>
                    <?php foreach ($data['certification_enum'] as $certification): ?>
                        <option <?php if (isset($entries['certification']) && $entries['certification'] === $certification)
                                    echo 'selected'; ?> value="<?= $certification ?>"><?= $certification ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cover">Upload cover</label>
                <input type="file" id="cover" name="cover_img">
            </div>

            <button type="submit" class="btn btn-secondary btn-full">
                <i class="fas fa-user-plus"></i>
                <?= $action ?>
            </button>
        </form>

    </div>
</div>