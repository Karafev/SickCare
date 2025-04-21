<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aliment extends Model
{
    protected $table = 'aliment_recettes';
    protected $primaryKey = 'id_aliment';
    protected $fillable = ['nom_aliment'];

    // Désactive les timestamps automatiques
    public $timestamps = false;

    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'Composer', 'id_aliment', 'id_recette');
    }

    public function maladies()
    {
        return $this->belongsToMany(Maladie::class, 'provoque_alergie_à', 'id_aliment', 'id_maladie');
    }
}
