<div class="main">
    <button class="conn" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/sickcares'">Gestion du catalogue</button><br>
    <div class="Box-users">
        <?php foreach ($maladies as $maladie): ?>
            <div class='Utilisateur card-style'>
                    <h2><?php echo "Maladie Numéro ".$maladie->id_maladie; ?></h2>
                    <?php echo $maladie->nom; ?><br>
                    
                    

                    <br>
                    <?php if (session()->get('nom') === "Admin"): ?>
                        
                        <form action="<?php echo base_url('maladies/delete/'.$maladie->id_maladie); ?>" method="POST" style="display:inline;">
                            <button class="Supr" type="submit" onclick="return confirm('Vous êtes sûr de vouloir supprimer cette maladie ?')">Supprimer</button>
                        </form>
                    
                    <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>