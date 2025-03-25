<?php
namespace App\Controllers;

use App\Models\Maladie;

class Maladies extends BaseController
{
    public function index()
    {
        // Récupérer tous les aliments
        $data['maladies'] = Maladie::all();
        $data['title'] = "Liste des aliments";

        // Charger la vue
        echo view('sickcares/templates/header', $data);
        echo view('sickcares/maladies', $data); // Vue pour afficher la liste des aliments
        echo view('sickcares/templates/footer');
    }
}