<?php
namespace App\Controllers;

use App\Models\Aliment;

class Aliments extends BaseController
{
    public function index()
    {
        // Récupérer tous les aliments
        $data['aliments'] = Aliment::all();
        $data['title'] = "Liste des aliments";

        // Charger la vue
        echo view('sickcares/templates/header', $data);
        echo view('sickcares/aliments/index', $data); // Vue pour afficher la liste des aliments
        echo view('sickcares/templates/footer');
    }
}