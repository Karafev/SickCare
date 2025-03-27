
<div class="main">
    <br>
        <div>
            <?php if (!session()->has('isLoggedIn') && !session('isLoggedIn')): ?>
                <button class="insc" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/inscription'">Inscription</button>
                <button class="conn" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/connexion'">Connexion</button><br>
            <?php endif; ?>
            <?php if (session()->has('isLoggedIn') && session('isLoggedIn')): ?>
                <?php  echo("Bienvenue "); echo session()->get('nom'); ?> <br>
                <a href="<?= base_url('deconnexion'); ?>">Déconnexion</a>
                <?php if (session()->get('nom') === "Admin"): ?><br><br>
                <button class="conn" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/utilisateurs'">Gestion des utilisateurs</button><br>
                <br>
                <button class="conn" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/maladies'">Gestion des maladies</button><br>
                <br>
                <?php echo view('sickcares/create'); ?>
            <?php endif; ?>
            <?php endif; ?>
        </div>
            <br>
            <div class="Box-Recette">
                <?php foreach ($Recettes as $Recette): ?>
                    <div class="Recette card-style">
                    <strong>Nom de la Recette :</strong><br>
                    <?php echo $Recette->nom_recette; ?><br>
                    <strong>Description</strong> <br>
                    <?php echo $Recette->description_recette; ?><br>
                    <strong>Ingrédient nécessaire :</strong><br>
                    <?php foreach ($Recette->aliments as $aliment) : ?>
                        <li>
                            <?= $aliment->nom_aliment ?>
                        </li>
                    <?php endforeach; ?>
                    
                    <strong>Etape pour la réalisation de la recette :</strong><br>
                    <?php echo $Recette->etape_recette; ?>
                    
                    <br>
                    <br>
                    <?php if (session()->has('isLoggedIn') && session('isLoggedIn')): ?>
                        <?php if (session()->get('nom') === "Admin"): ?><br><br>
                            <br>
                            <form action="<?php echo base_url('sickcares/delete/'.$Recette->id_recette) ?>" method="POST" style="display:inline;">
                                <button class ="Supr"type="submit" onclick="return confirm('Vous êtes sûr de vouloir supprimer cette recette ?')">Supprimer</button>
                            </form>
                            <br>
                        <?php endif; ?>
                    <?php endif; ?>
                    <br>
                    </div>
                <?php endforeach; ?>
            </div>
</div>
