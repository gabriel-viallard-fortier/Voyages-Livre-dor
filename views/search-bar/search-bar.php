<div class="search-container-wrapper">
    <form class="search-container" method="GET">
        <div class="search-input-wrapper">
            <label for="title" hidden>Rechercher par titre</label>
            <input tabindex="2" class="search-input" type="text" id="title" name="title" placeholder="Rechercher"
                value="<?= get('title') ?? '' ?>">
        </div>
        <div class="filter-wrapper">
            <label for="type" hidden>Catégories</label>
            <select tabindex="2" name="type" id="type">
                <option value="">Catégories</option>
                <option value="Movie" <?= get('type') === 'Movie' ? 'selected' : '' ?>>Films</option>
                <option value="Book" <?= get('type') === 'Book' ? 'selected' : '' ?>>Livres</option>
                <option value="Game" <?= get('type') === 'Game' ? 'selected' : '' ?>>Jeux</option>
            </select>
            <label for="genre" hidden>Genres</label>
            <select tabindex="2" name="genre" id="genre">
                <option value="">Genres</option>
                <?php foreach (get_genre_values() as $genre): ?>
                    <option value="<?= $genre ?>" <?= get('genre') === $genre ? 'selected' : '' ?>><?= $genre ?></option>
                <?php endforeach; ?>
            </select>
            <div class="checkbox-container">
                <label tabindex="2" for="available">Disponible</label>
                <input tabindex="2" class="checkbox" type="checkbox" id="available" name="available" <?= get('available') ? 'checked' : '' ?>>
            </div>
            <button title="lancer la recherche" tabindex="2" class="search-btn" type="submit"></button>
        </div>
    </form>
</div>