<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Vérifie si un utilisateur est connecté
        if (session()->has('utilisateur')) {
            // Redirige vers la page filtrée
            return redirect()->to('/dashboard');
        }

        // Sinon, page d’accueil publique par défaut
        return view('welcome_message');
    }
}
