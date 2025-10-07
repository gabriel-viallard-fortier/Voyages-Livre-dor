<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><?= $data['action'] ?> un livre</h2>
        </div>

        <form method="POST" class="auth-form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required placeholder="Titre du livre" value="<?php if (isset($entries['title']))
                                                                                                            e($entries['title']); ?>">
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <select id="genre" name="genre" required>
                    <option>Genre du livre</option>
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
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" required placeholder="Auteur" value="<?php if (isset($entries['author']))
                                                                                                        e($entries['author']); ?>">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" required placeholder="ISBN" value="<?php if (isset($entries['isbn']))
                                                                                                e($entries['isbn']); ?>">
            </div>

            <div class="form-group">
                <label for="pages">Pages</label>
                <input type="number" id="pages" name="pages" required placeholder="Nombre de pages" min="1" max="9999"
                    value="<?php if (isset($entries['pages']))
                                e($entries['pages']); ?>">
            </div>

            <div class="form-group">
                <label for="published_year">Date de publication</label>
                <input type="number" id="published_year" name="published_year" required
                    placeholder="Date de publication" min="1900" value="<?php if (isset($entries['published_year']))
                                                                            e($entries['published_year']); ?>">
            </div>

            <div class="form-group">
                <label for="summary">Résumé</label>
                <textarea id="summary" name="summary" placeholder="Résumé du livre" maxlength="3000"
                    autocomplete="on"><?php if (isset($entries['summary']))
                                            e($entries['summary']); ?></textarea>
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