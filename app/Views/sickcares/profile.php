<div class="main">
    <div class="profile-info">
    <button class="conn" onclick="window.location.href ='http://localhost/SickCare/public/sickcares'">Retour home</button><br>
        <h2>Informations du profil</h2>
        <div class="profile-details">
            <p><strong>Nom :</strong> <?= esc($user->nom) ?></p>
            <p><strong>Prénom :</strong> <?= esc($user->prenom) ?></p>
            <p><strong>Email :</strong> <?= esc($user->email) ?></p>
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

        <button class="conn" onclick="window.location.href ='http://localhost/SickCare/public/profile/edit'">Modifier le profil</button>
    </div>
</div>
