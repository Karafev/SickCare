<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Maladie;
use App\Models\Aliment;

class ProfileController extends BaseController
{
    // Affichage du profil de l'utilisateur
    public function index()
    {
        $userId = session()->get('id_compte');  // Récupérer l'ID de l'utilisateur connecté

        // Vérifier si l'utilisateur est connecté
        if (!$userId) {
            return redirect()->to('/connexion')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les informations de l'utilisateur avec ses maladies et aliments associés
        $user = User::with('maladies.aliments')->find($userId);

        if (!$user) {
            return redirect()->to('/connexion')->with('error', 'Utilisateur introuvable.');
        }

        // Passer les données à la vue
        $data = [
            'title' => 'Profil de l\'utilisateur',
            'user' => $user
        ];

        // Charger les vues (header, profil, footer)
        return view('sickcares/templates/header', $data) . 
               view('sickcares/profile', $data) .
               view('sickcares/templates/footer');
    }

    // Affichage du formulaire d'édition du profil
    public function edit()
{
    // Vérifier si l'utilisateur est connecté
    $userId = session()->get('id_compte');
    $user = \App\Models\User::find($userId);

    if (!$user) {
        return redirect()->to('/profile')->with('error', 'Utilisateur non trouvé');
    }

    // Passer les données à la vue
    $data = [
        'title' => 'Modifier le profil',
        'user' => $user
    ];

    // Charger la vue 'sickcares/edit_profile'
    return view('sickcares/templates/header', $data) .
    view('sickcares/edit_profile', $data).
    view('sickcares/templates/footer', $data);
}


    // Mise à jour des informations du profil
    public function update()
{
    $userId = session()->get('id_compte');

    if (!$userId) {
        return redirect()->to('/connexion')->with('error', 'Vous devez être connecté.');
    }

    $user = User::find($userId);

    if (!$user) {
        return redirect()->to('/connexion')->with('error', 'Utilisateur introuvable.');
    }

    $motDePasse = $this->request->getPost('mot_de_passe');

    $data = [
        'nom' => $this->request->getPost('nom'),
        'prenom' => $this->request->getPost('prenom'),
        'email' => $this->request->getPost('email'),
    ];

    if (!empty($motDePasse)) {
        $data['mot_de_passe'] = password_hash($motDePasse, PASSWORD_DEFAULT);
    }

    $user->update($data);

    // Gestion de l'ajout de maladie
    $maladieInput = $this->request->getPost('maladie');
    if (!empty($maladieInput)) {
        $maladie = Maladie::firstOrCreate(['nom' => $maladieInput]);
        $user->maladies()->syncWithoutDetaching([$maladie->id_maladie]);
    }

    return redirect()->to('/profile')->with('success', 'Profil mis à jour.');
}

    

}
