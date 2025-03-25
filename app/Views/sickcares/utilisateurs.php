<div class="main">
    <button class="conn" onclick="window.location.href ='http://localhost/~fevzican.karamercan/SickCare/public/sickcares'">Gestion du catalogue</button><br>
    <div class="Box-users">
        <?php foreach ($users as $user): ?>
            <div class='Utilisateur card-style'>
                    <h2><?php echo "Utilisateur Numéro ".$user->id_compte; ?></h2>
                    <?php echo $user->nom; ?><br>
                    <?php echo $user->prenom; ?><br>
                    <?php echo $user->email; ?><br>
                    

                    <br>
                    <?php if (session()->get('nom') === "Admin"): ?>
                        
                        <form action="<?php echo base_url('utilisateurs/delete/'.$user->id_compte); ?>" method="POST" style="display:inline;">
                            <button class="Supr" type="submit" onclick="return confirm('Vous êtes sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    
                    <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>