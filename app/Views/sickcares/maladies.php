<div class="main">
    <button class="conn" onclick="window.location.href ='sickcares'">Gestion du catalogue</button><br>

    <div class="Box-users">
        <?php foreach ($maladies as $maladie): ?>
            <div class="Utilisateur card-style">
                <h2><?php echo "Maladie Numéro " . $maladie->id_maladie; ?></h2>
                <p><?php echo $maladie->nom; ?></p>
                
                <h3>Aliments interdit(s) :</h3>
                <ul>
                    <?php foreach ($maladie->aliments as $aliment): ?>
                        <li><?php echo esc($aliment->nom_aliment); ?></li>
                    <?php endforeach; ?>
                </ul>

                <?php if (session()->get('nom') === "Admin"): ?>
                    <form action="<?php echo base_url('maladies/delete/'.$maladie->id_maladie); ?>" method="POST" style="display:inline;">
                        <button class="Supr" type="submit" onclick="return confirm('Vous êtes sûr de vouloir supprimer cette maladie ?')">Supprimer</button>
                    </form>
                    <form action="<?php echo base_url('maladies/edit/'.$maladie->id_maladie); ?>" method="GET" style="display:inline;">
                        <button class="Supr" type="submit">Éditer</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
