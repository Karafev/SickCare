<?php
namespace App\Controllers;

use App\Models\Recette;
use App\Models\Aliment;
use App\Models\Etape;

class Recettes extends BaseController
{
    public function index()
    {
        $query = Recette::with('aliments');
        $allIngredients = Aliment::orderBy('nom_aliment', 'ASC')->get();

        // Vérifie si le filtrage auto est activé (true par défaut)
        $filterEnabled = session()->get('filter_enabled', true);

        // Si l'utilisateur est connecté ET que le filtrage est activé
        if (session()->has('isLoggedIn') && $filterEnabled) {
            $userId = session()->get('id_compte');
            $user = \App\Models\User::with('maladies.aliments')->find($userId);

            if ($user) {
                $alimentsInterdits = $user->maladies->flatMap(function($maladie) {
                    return $maladie->aliments->pluck('id_aliment');
                })->unique()->toArray();

                if (!empty($alimentsInterdits)) {
                    $query->whereDoesntHave('aliments', function($q) use ($alimentsInterdits) {
                        $q->whereIn('aliment_recettes.id_aliment', $alimentsInterdits);
                    });
                }
            }
        }

        $data = [
            'Recettes' => $query->get(),
            'allIngredients' => $allIngredients,
            'title' => "Liste des recettes",
            'filterEnabled' => $filterEnabled,
            'searchTerm' => '',
            'selectedIngredients' => []
        ];

        echo view('sickcares/templates/header', $data);
        echo view('sickcares/index', $data);
        echo view('sickcares/templates/footer');
    }

    public function toggleFilter()
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->back()->with('error', 'Connectez-vous pour modifier ce paramètre');
        }

        // Inverse l'état actuel du filtre
        $currentState = session()->get('filter_enabled', true);
        session()->set('filter_enabled', !$currentState);

        return redirect()->back();
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
            // Instancier la recette
            $recette = new Recette();
            $recette->nom_recette = $this->request->getPost('nom_recette');
            $recette->description_recette = $this->request->getPost('description_recette');
            $recette->etape_recette = $this->request->getPost('etape_recette');

            // Sauvegarde la recette dans la base de données
            $recette->save();

            // Maintenant que la recette est sauvegardée, récupère l'instance complète pour ajouter les aliments
            $recette = Recette::find($recette->id_recette); // Recherche la recette fraîchement sauvegardée

            // Ajout des aliments à la recette
            $aliments = $this->request->getPost('aliment_recette');
            foreach ($aliments as $nom_aliment) {
                $aliment = Aliment::firstOrCreate(['nom_aliment' => $nom_aliment]);
                $recette->aliments()->attach($aliment->id_aliment);
            }

            // Redirige avec succès
            return redirect()->to('/sickcares')->with('success', 'Recette créée avec succès!');
        } else {
            // Si la validation échoue
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
                $q->whereIn('Aliment_recettes.id_aliment', $selectedIngredients);
            }
        }]);

        // Filtre par terme de recherche
        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('recettes.nom_recette', 'LIKE', "%$searchTerm%")
                  ->orWhere('recettes.description_recette', 'LIKE', "%$searchTerm%")
                  ->orWhereHas('aliments', function($q) use ($searchTerm) {
                      $q->where('Aliment_recettes.nom_aliment', 'LIKE', "%$searchTerm%");
                  });
            });
        }

        // Filtre par ingrédients sélectionnés
        if (!empty($selectedIngredients)) {
            $query->whereHas('aliments', function($q) use ($selectedIngredients) {
                $q->whereIn('Aliment_recettes.id_aliment', $selectedIngredients);
            }, '>=', count($selectedIngredients));
        }

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
