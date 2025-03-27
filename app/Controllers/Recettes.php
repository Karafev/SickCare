<?php
namespace App\Controllers;

use App\Models\Recette;
use App\Models\Aliment;
use App\Models\Etape;

class Recettes extends BaseController
{
    public function index()
    {
        // Correction : on récupère TOUTES les recettes avec leurs aliments
        $recettes = Recette::with('aliments')->get();

        $data['Recettes'] = $recettes;
        $data['title'] = "Liste des recettes";

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

                $etapes = $this->request->getPost('etape_recette');
                if (is_array($etapes)) {
                    $recette->etape_recette = implode(",\n", $etapes);
                }

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
