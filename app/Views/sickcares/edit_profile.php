<div class="main">
    <form action="<?php echo base_url(); ?>/profile/update" method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= esc($user->nom) ?>" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="<?= esc($user->prenom) ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= esc($user->email) ?>" required>
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe">
        </div>

        <h3>Maladies associées :</h3>
        <?php if (!empty($user->maladies)): ?>
            <ul class="maladies-list">
                <?php foreach ($user->maladies as $maladie): ?>
                    <li>
                        <?= esc($maladie->nom) ?>
                        
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucune maladie associée.</p>
        <?php endif; ?>

        <!-- Formulaire pour ajouter une maladie -->
        <div class="form-group">
            <label for="maladie">Ajouter une maladie :</label>
            <input type="text" name="maladie" id="maladie" value="">
        </div>

        <button type="submit" class="btn-update-profile">Mettre à jour</button>
    </form>
</div>
