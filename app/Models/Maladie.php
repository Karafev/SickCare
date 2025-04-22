<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maladie extends Model
{
    protected $table = 'maladie';
    protected $primaryKey = 'id_maladie';
    public $timestamps = false;

    protected $fillable = [
        'nom',
    ];

    // Relation Many-to-Many avec Aliment via la table pivot
    public function aliments()
    {
        return $this->belongsToMany(Aliment::class, 'provoque_alergie_à', 'id_maladie', 'id_aliment');
    }
}

