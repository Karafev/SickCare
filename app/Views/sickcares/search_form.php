<div class="search-container">
    <form action="<?= base_url('recettes/search') ?>" method="get">
        <input type="text" name="q" value="<?= esc($q ?? '') ?>" placeholder="Rechercher une recette...">
        
        <div class="ingredient-filter">
            <h4>Filtrer par ingrédients :</h4>
            <div class="ingredient-list">
                <?php foreach ($allIngredients as $ingredient): ?>
                    <div class="ingredient-checkbox">
                        <input type="checkbox" 
                               name="ingredients[]" 
                               id="ing-<?= $ingredient->id_aliment ?>"
                               value="<?= $ingredient->id_aliment ?>"
                               <?= in_array($ingredient->id_aliment, $selectedIngredients) ? 'checked' : '' ?>>
                        <label for="ing-<?= $ingredient->id_aliment ?>">
                            <?= esc($ingredient->nom_aliment) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <button type="submit">Rechercher</button>
    </form>
</div>