<?php
namespace App\Controllers;

use App\Models\Recette;
use App\Models\Aliment;
use App\Models\Etape;

class Recettes extends BaseController
{
    public function index()
{
    // Récupère toutes les recettes avec leurs aliments associés
    $recettes = Recette::with('aliments')->get();
    
    // Récupère tous les ingrédients pour le filtre, triés par nom
    $allIngredients = Aliment::orderBy('nom_aliment', 'ASC')->get();

    // Prépare les données pour la vue
    $data = [
        'Recettes' => $recettes,
        'allIngredients' => $allIngredients, // Ajout de la variable manquante
        'title' => "Liste des recettes",
        'searchTerm' => '', // Initialisation pour éviter des erreurs dans la vue
        'selectedIngredients' => [] // Initialisation du tableau des ingrédients sélectionnés
    ];

    // Charge les vues avec les données
    echo view('sickcares/templates/header', $data);
    echo view('sickcares/index', $data);
    echo view('sickcares/templates/footer');
}

    
    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'nom_recette' => 'required|min_length[3]',
                'description_recette' => 'required',
                'aliment_recette' => 'required',
                'etape_recette' => 'required'
            ];

            if ($this->validate($rules)) {
                $recette = new Recette();
                $recette->nom_recette = $this->request->getPost('nom_recette');
                $recette->description_recette = $this->request->getPost('description_recette');
                $recette->etape_recette = $this->request->getPost('etape_recette');

                $recette->save();

                // Récupérer l'instance complète après save() pour lier les aliments
                $recette = Recette::find($recette->id_recette);

                $aliments = $this->request->getPost('aliment_recette');
                foreach ($aliments as $nom_aliment) {
                    $aliment = Aliment::firstOrCreate(['nom_aliment' => $nom_aliment]);
                    $recette->aliments()->attach($aliment->id_aliment);
                }

                return redirect()->to('/sickcares')->with('success', 'Recette créée avec succès!');
            } else {
                $data['title'] = 'Ajouter une recette';
                $data['validation'] = $this->validator;
                echo view('sickcares/templates/header', $data);
                echo view('sickcares/create', $data);
                echo view('sickcares/templates/footer');
            }
        } else {
            $data['title'] = 'Ajouter une recette';
            echo view('sickcares/templates/header', $data);
            echo view('sickcares/create');
            echo view('sickcares/templates/footer');
        }
    }
    public function search()
{
    $searchTerm = $this->request->getGet('q');
    $selectedIngredients = $this->request->getGet('ingredients') ?? [];

    // Requête de base avec eager loading
    $query = Recette::with(['aliments' => function($q) use ($selectedIngredients) {
        if (!empty($selectedIngredients)) {
            $q->whereIn('id_aliment', $selectedIngredients);
        }
    }]);

    // Filtre par terme de recherche
    if (!empty($searchTerm)) {
        $query->where(function($q) use ($searchTerm) {
            $q->where('nom_recette', 'LIKE', "%$searchTerm%")
              ->orWhere('description_recette', 'LIKE', "%$searchTerm%")
              ->orWhereHas('aliments', function($q) use ($searchTerm) {
                  $q->where('nom_aliment', 'LIKE', "%$searchTerm%");
              });
        });
    }

    // Filtre par ingrédients sélectionnés
    if (!empty($selectedIngredients)) {
        $query->whereHas('aliments', function($q) use ($selectedIngredients) {
            $q->whereIn('id_aliment', $selectedIngredients);
        }, '>=', count($selectedIngredients));
    }

    // Récupération des résultats sans doublons
    $recettes = $query->distinct()->get();

    $data = [
        'Recettes' => $recettes,
        'allIngredients' => Aliment::orderBy('nom_aliment')->get(),
        'selectedIngredients' => $selectedIngredients,
        'searchTerm' => $searchTerm,
        'title' => 'Résultats de recherche'
    ];

    return view('sickcares/templates/header', $data)
         . view('sickcares/index', $data)
         . view('sickcares/templates/footer');
}
    public function delete($id)
    {
        $recette = Recette::find($id);
        if ($recette) {
            $recette->aliments()->detach();
            if (method_exists($recette, 'etapes')) {
                $recette->etapes()->delete(); // seulement si tu gères des étapes liées
            }
            $recette->delete();
        }
        return redirect()->to('/sickcares')->with('success', 'Recette supprimée avec succès!');
    }
}
