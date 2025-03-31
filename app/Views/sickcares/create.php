<?= \Config\Services::validation()->listErrors() ?>
<div class="div-details">
    <?= csrf_field() ?>
    
    <details id="myDetails">
        <summary>Formulaire de création de recette</summary>
        <!-- Changed action to match your routes -->
        <form class="form1" action="<?= base_url('sickcares/create') ?>" method="POST">
            <div class="div-create">
                <label for="nom_recette">Nom Recette</label><br />
                <input type="text" name="nom_recette" value="<?= old('nom_recette') ?>" required><br />
            </div>
            <div class="div-create">
                <label for="description_recette">Description recette</label><br />
                <textarea name="description_recette" required><?= old('description_recette') ?></textarea><br />
            </div>

            <div class="div-create" id="Aliment-container">
                <label for="aliment_recette">Ingredient recette</label><br />
                <input class="input-button" type="button" onclick="addAlimentField()" value="Ajouter un ingredient"><br />
                <?php if (!empty(old('aliment_recette'))) : ?>
                    <?php foreach (old('aliment_recette') as $aliment) : ?>
                        <input type="text" name="aliment_recette[]" value="<?= esc($aliment) ?>" required><br />
                    <?php endforeach ?>
                <?php else : ?>
                    <input type="text" name="aliment_recette[]" required><br />
                <?php endif ?>
            </div>
    
            <div class="div-create">
                <label for="etape_recette">Etape recette</label><br />
                <textarea name="etape_recette" required><?= old('etape_recette') ?></textarea><br />
            </div>
            
            <br>
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
        newInput.className = "form-control"; // Add consistent styling
        container.appendChild(newInput);
        container.appendChild(document.createElement("br"));
    }

    // Optional: Add similar function for steps if needed
    function addStepField() {
        var container = document.getElementById("step-container");
        var newTextarea = document.createElement("textarea");
        newTextarea.name = "etape_recette[]";
        newTextarea.required = true;
        newTextarea.className = "form-control";
        container.insertBefore(newTextarea, container.lastElementChild);
        container.insertBefore(document.createElement("br"), container.lastElementChild);
    }
</script>