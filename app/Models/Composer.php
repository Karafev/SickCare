<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Composer extends Pivot
{
    public function up()
    {
        Schema::create('aliment_recettes', function (Blueprint $table) {
            $table->id(); // Identifiant primaire pour la table pivot
            $table->foreignId('id_recette')->constrained()->onDelete('cascade'); // Clé étrangère vers la table `recettes`
            $table->foreignId('id_aliment')->constrained()->onDelete('cascade'); // Clé étrangère vers la table `aliments`
            $table->timestamps(); // Pour enregistrer les dates de création et de mise à jour
        });
    }
}