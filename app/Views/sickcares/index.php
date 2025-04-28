<div class="main">
    <br>

    <!-- Boutons Connexion / Inscription -->
    <?php if (!session()->has('isLoggedIn') || !session('isLoggedIn')): ?>
        <button class="insc" onclick="window.location.href = '<?= base_url('inscription') ?>'">Inscription</button>
        <button class="conn" onclick="window.location.href = '<?= base_url('connexion') ?>'">Connexion</button>
    <?php endif; ?>

    <!-- Si l'utilisateur est connecté -->
    <?php if (session()->has('isLoggedIn') && session('isLoggedIn')): ?>
        <p>Bienvenue <strong><?= esc(session()->get('nom')) ?></strong></p><br>
        <p>Vous avez <strong><?= esc(session()->get('maladies')) ?></strong></p>

        <a href="<?= base_url('deconnexion') ?>">Déconnexion</a>
        <br><br>

        <button class="conn" onclick="window.location.href = '<?= base_url('profile') ?>'">Profil</button>

        <!-- Options Admin -->
        <?php if (session()->get('id_compte') === 1): ?>
            <br><br>
            <button class="conn" onclick="window.location.href = '<?= base_url('utilisateurs') ?>'">Gestion des utilisateurs</button>
            <button class="conn" onclick="window.location.href = '<?= base_url('maladies') ?>'">Gestion des maladies</button><br><br>

            <!-- Formulaire de création visible uniquement pour Admin -->
            <?= view('sickcares/create') ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Barre de recherche -->
    <?= view('sickcares/search_form') ?>

    <!-- Filtre santé -->
    <?php if (session()->has('isLoggedIn')): ?>
        <div class="filter-toggle">
            <form action="<?= base_url('recettes/toggle-filter') ?>" method="post">
                <?= csrf_field() ?>
                <label class="switch">
                    <input type="checkbox" name="filter_toggle"
                           onchange="this.form.submit()"
                           <?= $filterEnabled ? 'checked' : '' ?>>
                    <span class="slider round"></span>
                </label>
                <span class="filter-label <?= $filterEnabled ? 'active' : 'inactive' ?>">
                    <?= $filterEnabled ? 'Filtre santé activé' : 'Filtre santé désactivé' ?>
                </span>
            </form>
        </div>
    <?php endif; ?>

    <br>

    <!-- Affichage des recettes -->
    <div class="Box-Recette">
        <?php foreach ($Recettes as $Recette): ?>
            <div class="Recette card-style">
                <!-- Image -->
                <?php if (!empty($Recette->image_recette)) : ?>
                    <img src="<?= base_url($Recette->image_recette) ?>" alt="Image de la recette" style="max-width: 100%; border-radius: 10px;">
                <?php else: ?>
                    <p><em>Aucune image disponible.</em></p>
                <?php endif; ?><br><br>

                <!-- Informations recette -->
                <strong>Nom de la Recette :</strong><br>
                <?= esc($Recette->nom_recette) ?><br><br>

                <strong>Description :</strong><br>
                <?= esc($Recette->description_recette) ?><br><br>

                <strong>Ingrédients nécessaires :</strong>
                <ul>
                    <?php foreach ($Recette->aliments as $aliment): ?>
                        <li><?= esc($aliment->nom_aliment) ?></li>
                    <?php endforeach; ?>
                </ul>

                <strong>Étapes de la recette :</strong><br>
                <?= nl2br(esc($Recette->etape_recette)) ?><br><br>

                <!-- Bouton de suppression si admin -->
                <?php if (session()->has('isLoggedIn') && session()->get('nom') === "Admin"): ?>
                    <form action="<?= base_url('sickcares/delete/' . $Recette->id_recette) ?>" method="POST" onsubmit="return confirm('Supprimer cette recette ?')">
                        <?= csrf_field() ?>
                        <button class="Supr" type="submit">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
