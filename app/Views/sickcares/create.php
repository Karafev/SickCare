<?= \Config\Services::validation()->listErrors() ?>
<div class="div-details">
    <?= csrf_field() ?>
    <details id="myDetails">
        <summary>Formulaire de création de recette</summary>
        <!-- Action du formulaire -->
        <form class="form1" action="<?= base_url('sickcares/create') ?>" method="POST" enctype="multipart/form-data">
            <div class="div-create">
                <label for="nom_recette">Nom Recette</label><br />
                <input type="text" name="nom_recette" value="<?= old('nom_recette') ?>" required><br />
            </div>
            <div class="div-create">
                <label for="description_recette">Description recette</label><br />
                <textarea name="description_recette" required><?= old('description_recette') ?></textarea><br />
            </div>

            <div class="div-create" id="Aliment-container">
                <label for="aliment_recette">Ingrédient recette</label><br />
                <input class="input-button" type="button" onclick="addAlimentField()" value="Ajouter un ingrédient"><br />
                <?php if (!empty(old('aliment_recette'))) : ?>
                    <?php foreach (old('aliment_recette') as $aliment) : ?>
                        <input type="text" name="aliment_recette[]" value="<?= esc($aliment) ?>" required><br />
                    <?php endforeach ?>
                <?php else : ?>
                    <input type="text" name="aliment_recette[]" required><br />
                <?php endif ?>
            </div>
    
            <div class="div-create">
                <label for="etape_recette">Étape recette</label><br />
                <textarea name="etape_recette" required><?= old('etape_recette') ?></textarea><br />
            </div>

            <div class="div-create">
                <label for="image_recette">Image de la recette</label><br />
                <input type="file" name="image_recette" accept="image/*" required><br />
            </div>

            <div class="div-create" id="step-container">
                <input class="input-button" type="submit" name="submit" value="Ajouter recette" />
            </div>
        </form>
    </details>
</div>

<script>
    function addAlimentField() {
        var container = document.getElementById("Aliment-container");
        var newInput = document.createElement("input");
        newInput.type = "text";
        newInput.name = "aliment_recette[]";
        newInput.required = true;
        newInput.className = "form-control";
        container.appendChild(newInput);
        container.appendChild(document.createElement("br"));
    }
</script>
