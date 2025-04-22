<?php

namespace App\Controllers;

use App\Models\Maladie;
use App\Models\Aliment;

class Maladies extends BaseController
{
    public function index()
    {
        // Récupérer toutes les maladies
        $maladies = Maladie::all();

        // Passer les données à la vue
        $data = [
            'title' => 'Gestion des maladies',
            'maladies' => $maladies
        ];

        // Charger la vue pour afficher la liste des maladies
        echo view('sickcares/templates/header', $data); // Charge le header
        echo view('sickcares/maladies', $data);        // Charge la vue principale
        echo view('sickcares/templates/footer');       // Charge le footer
    }

    public function edit($id)
    {
        // Récupérer la maladie avec ses aliments associés
        $maladie = Maladie::with('aliments')->find($id);
    
        if (!$maladie) {
            return redirect()->to('/maladies')->with('error', 'Maladie non trouvée');
        }
    
        // Récupérer tous les aliments disponibles
        $aliments = Aliment::all();
    
        // Passer les données à la vue
        $data = [
            'title' => 'Associer des aliments à la maladie',
            'maladie' => $maladie,
            'aliments' => $aliments
        ];
    
        // Charger les vues (header, corps, footer)
        return view('sickcares/templates/header', $data) .
               view('sickcares/associer_maladies', $data) .
               view('sickcares/templates/footer');
    }
    


    public function update($id)
{
    // Récupérer la maladie
    $maladie = Maladie::find($id);

    // Vérifier si la maladie existe
    if (!$maladie) {
        return redirect()->to('/maladies')->with('error', 'Maladie non trouvée');
    }

    // Toujours forcer un tableau (même vide) pour gérer la désélection complète
    $selectedAliments = $this->request->getPost('aliments') ?? [];

    // Vérification (optionnelle) que les aliments existent — seulement si non vide
    if (!empty($selectedAliments)) {
        foreach ($selectedAliments as $alimentId) {
            if (!Aliment::find($alimentId)) {
                return redirect()->to('/maladies/edit/' . $id)->with('error', 'Un aliment sélectionné n\'existe pas');
            }
        }
    }

    // Mettre à jour les liaisons
    try {
        $maladie->aliments()->sync($selectedAliments);
    } catch (\Exception $e) {
        return redirect()->to('/maladies/edit/' . $id)->with('error', 'Erreur lors de l\'association des aliments : ' . $e->getMessage());
    }

    return redirect()->to('/maladies')->with('success', 'Aliments associés à la maladie');
}

    

    


    public function delete($id)
{
    // Récupérer la maladie
    $maladie = Maladie::find($id);

    // Vérifier si la maladie existe
    if ($maladie) {
        // Supprimer la maladie et ses associations
        $maladie->delete();
        return redirect()->to('/maladies')->with('success', 'Maladie supprimée avec succès');
    }

    return redirect()->to('/maladies')->with('error', 'Maladie non trouvée');
}

}

