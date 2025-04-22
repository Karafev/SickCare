<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $table = 'recettes';
    protected $primaryKey = 'id_recette';
    public $timestamps = false;

    protected $fillable = [
        'nom_recette',
        'description_recette',
        'image_recette', 
    ];

    // Relation Many-to-Many avec Aliment via la table Composer
    public function aliments()
    {
        return $this->belongsToMany(Aliment::class, 'Composer', 'id_recette', 'id_aliment');
    }
}