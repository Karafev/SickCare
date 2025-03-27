<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maladie extends Model
{
    protected $table = 'Maladie';
    protected $primaryKey = 'id_maladie';
    public $timestamps = false;

    protected $fillable = [
        'nom',
    ];

    // Relation Many-to-Many avec Aliment via la table Composer
    public function aliments()
    {
        return $this->belongsToMany(
            'App\Models\Aliment',        // Modèle cible
            'provoque_alergie_a',        // Table de jointure
            'id_maladie',                // Clé étrangère locale
            'id_aliment'                 // Clé étrangère cible
        );
    }
    public function users()
    {
        return $this->belongsToMany(Aliment::class, 'Etre_malade', 'id_maladie', 'id_compte');
    }
}