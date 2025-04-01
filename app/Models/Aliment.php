<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aliment extends Model
{
    protected $table = 'Aliment_recettes';
    protected $primaryKey = 'id_aliment';
    public $timestamps = false;

    protected $fillable = [
        'nom_aliment'
    ];

    // Relation Many-to-Many avec Recette via la table Composer
    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'Composer', 'id_aliment', 'id_recette');
    }

    public function maladies()
    {
        return $this->belongsToMany(Maladie::class,'provoque_alergie_à','id_aliment','id_maladie');
    }
}