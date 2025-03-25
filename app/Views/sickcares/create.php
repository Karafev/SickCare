<?= \Config\Services::validation()->listErrors() ?>
<div class="div-details">

    <?= csrf_field() ?>

    <details id="myDetails">
        <summary>Formulaire de création de recette</summary>
        <form class="form1" action="create" method="POST">
            <div class="div-create">
                <label for="nom_recette">Nom Recette</label><br />
                <input type="text" name="nom_recette" required><br />
            </div>
            <div class="div-create">
                <label for="description_recette">Description recette</label><br />
                <textarea name="description_recette" required></textarea><br />
            </div>

                
                <div class="div-create" id="Aliment-container">
                    <label for="aliment_recette">Ingredient recette</label><br />
                    <input class="input-button" type="button" onclick="addAlimentField()" value="Ajouter un ingredient"><br />
                    <input type="text" name="aliment_recette[]" required><br />
                    
                </div>
                <div class="div-create" id="step-container">
                    <label for="etape_recette">Etape recette</label><br />
                    <input class="input-button"type="button" onclick="addStepField()" value="Ajouter un étape"><br />
                    <input type="text" name="etape_recette[]" required><br />

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
        container.appendChild(newInput);
        container.appendChild(document.createElement("br"));
    }



    function addStepField() {
        var container = document.getElementById("step-container");
        var newInput = document.createElement("input");
        newInput.type = "text";
        newInput.name = "etape_recette[]";
        newInput.required = true;
        container.appendChild(newInput);
        container.appendChild(document.createElement("br"));
    }
   
</script>