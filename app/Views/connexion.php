<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <title>Se connecter</title>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-5">
                <h2>Se connecter</h2>
                    <?php if(session()->getFlashdata('msg')):?>
                <div class="alert alert-warning">
                    <?= session()->getFlashdata('msg') ?>
                </div>
                <?php endif;?>
                <form action="<?php echo base_url(); ?>traiteConnexion" method="post">
                <div class="form-group mb-3">
                    <input type="email" name="email"placeholder="Email" value="<?= isset($_POST['email']) ? esc($_POST['email']) : '' ?>" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="mot_de_passe" placeholder="Password" class="form-control" >
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Connexion</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>