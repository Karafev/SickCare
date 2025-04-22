<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DeconnexionController extends Controller
{
    public function index()
    {
        // Détruire la session
        session()->destroy();

        // Rediriger l'utilisateur vers la page de connexion ou d'accueil
        return redirect()->to('/sickcares');
    }
}
