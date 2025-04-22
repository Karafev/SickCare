<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_compte';
    public $timestamps=false ;

    protected $fillable = [
        'email',
        'mot_de_passe',
        'nom',
        'prenom'
    ];

    public function maladies()
    {
        return $this->belongsToMany(Maladie::class, 'Etre_malade', 'id_compte', 'id_maladie');
    }
}