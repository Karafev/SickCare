<form method="post" action="<?= site_url('maladies/update/' . $maladie->id_maladie) ?>" class="form-mise-a-jour">
    <?= csrf_field() ?>

    <label for="aliments" class="label-aliments">Sélectionner les aliments :</label>
    <div class="aliments-list">
        <?php foreach ($aliments as $aliment): ?>
            <div class="aliment-item">
                <input type="checkbox" 
                       name="aliments[]" 
                       id="aliment-<?= esc($aliment->id_aliment) ?>"
                       value="<?= esc($aliment->id_aliment) ?>"
                       <?php 
                           // Vérification si l'aliment est déjà associé à la maladie
                           if ($maladie->aliments->contains('id_aliment', $aliment->id_aliment)) {
                               echo 'checked';
                           }
                       ?>>
                <label for="aliment-<?= esc($aliment->id_aliment) ?>">
                    <?= esc($aliment->nom_aliment) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn-submit">Mettre à jour</button>
</form>
